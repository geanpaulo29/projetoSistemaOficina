<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    // Exibe o formulário de cadastro de serviço
    public function create()
    {
        $clientes = Cliente::all();
        $veiculos = Veiculo::all();
        return view('servicos.create', compact('clientes', 'veiculos'));
    }

    // Salva o serviço no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'descricao' => 'required|string',
            'valor' => 'required|numeric|min:0',
            'data_servico' => 'required|date',
        ]);

        Servico::create($request->all());

        return redirect()->route('servicos.index')->with('success', 'Serviço cadastrado com sucesso!');
    }

    // Lista todos os serviços com paginação
    public function index()
    {
        $servicos = Servico::with(['veiculo.cliente'])->paginate(10); // Paginação com 10 itens por página
        return view('servicos.index', compact('servicos'));
    }

    // Exibe o formulário de busca de serviços
    public function search()
    {
        $servicos = Servico::with(['veiculo.cliente'])->get(); // Carrega todos os serviços para exibir na página de busca
        return view('servicos.search', compact('servicos'));
    }

    // Processa a busca de serviços
    public function find(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);
    
        $search = $request->input('search');
    
        // Busca serviços pela descrição, valor, data, placa, nome do veículo ou nome do cliente
        $servicos = Servico::where('descricao', 'like', "%$search%")
            ->orWhere('valor', 'like', "%$search%")
            ->orWhere('data_servico', 'like', "%$search%")
            ->orWhereHas('veiculo', function ($query) use ($search) {
                $query->where('placa', 'like', "%$search%")
                      ->orWhere('modelo', 'like', "%$search%");
            })
            ->orWhereHas('veiculo.cliente', function ($query) use ($search) {
                $query->where('nome', 'like', "%$search%");
            })
            ->paginate(10); // Paginação com 10 itens por página
    
        return view('servicos.index', compact('servicos'));
    }

    // Exibe o formulário de edição de serviço
    public function edit($id)
    {
        $servico = Servico::findOrFail($id);
        $veiculos = Veiculo::all();
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