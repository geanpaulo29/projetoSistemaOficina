<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Cliente;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    // Exibe o formulário de cadastro de serviço
    public function create()
    {
        // Busca todos os veículos com seus clientes associados
        $veiculos = Veiculo::with('cliente')->get();
        return view('servicos.create', compact('veiculos'));
    }

    // Salva o serviço no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id', // Garante que o veículo existe
            'descricao' => 'required|string',
            'valor' => 'required|numeric|min:0',
            'data_servico' => 'required|date',
        ]);
    
        // Verifica se o veículo existe
        $veiculo = Veiculo::find($request->veiculo_id);
        if (!$veiculo) {
            return redirect()->back()->withErrors(['error' => 'Veículo não encontrado.']);
        }
    
        // Cria o serviço
        Servico::create($request->only(['veiculo_id', 'descricao', 'valor', 'data_servico']));
    
        return redirect()->route('servicos.index')->with('success', 'Serviço cadastrado com sucesso!');
    }

    // Lista todos os serviços
    public function index()
    {
        // Carrega os serviços com os relacionamentos veículo e cliente
        $servicos = Servico::with(['veiculo.cliente'])->get();
        return view('servicos.index', compact('servicos'));
    }
        // Exibe o formulário de edição de serviço
    public function edit($id)
    {
        $servico = Servico::findOrFail($id);
        $veiculos = Veiculo::with('cliente')->get(); // Busca todos os veículos para o formulário
        return view('servicos.edit', compact('servico', 'veiculos'));
    }

    // Atualiza o serviço no banco de dados
    public function update(Request $request, $id)
    {
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'descricao' => 'required|string',
            'valor' => 'required|numeric|min:0',
            'data_servico' => 'required|date',
        ]);

        $servico = Servico::findOrFail($id);
        $servico->update($request->all());

        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso!');
    }

    // Exclui o serviço do banco de dados
    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();

        return redirect()->route('servicos.index')->with('success', 'Serviço excluído com sucesso!');
    }
}