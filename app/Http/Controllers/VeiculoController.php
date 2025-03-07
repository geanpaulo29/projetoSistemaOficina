<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Cliente; // Importe a classe Cliente
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    // Exibe o formulário de cadastro de veículo
    public function create()
    {
        $clientes = Cliente::all(); // Busca todos os clientes para o formulário
        return view('veiculos.create', compact('clientes'));
    }

    // Exibe a lista de veículos com paginação
    public function index()
    {
        $veiculos = Veiculo::with('cliente')->paginate(10); // Paginação com 10 itens por página
        return view('veiculos.index', compact('veiculos'));
    }

    // Exibe o formulário de busca de veículos
    public function search()
    {
        $clientes = Cliente::all(); // Busca todos os clientes
        $veiculos = Veiculo::with('cliente')->get(); // Carrega todos os veículos para exibir na página de busca
        return view('veiculos.search', compact('veiculos', 'clientes')); // Passa ambas as variáveis para a view
    }

    // Processa a busca de veículos
    public function find(Request $request)
    {
        $query = Veiculo::query();
    
        // Filtro por termo de busca geral
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('modelo', 'like', "%$search%")
                  ->orWhere('placa', 'like', "%$search%")
                  ->orWhere('marca', 'like', "%$search%");
            });
        }
    
        // Filtros avançados
        if ($request->filled('modelo')) {
            $query->where('modelo', 'like', "%{$request->input('modelo')}%");
        }
        if ($request->filled('placa')) {
            $query->where('placa', 'like', "%{$request->input('placa')}%");
        }
        if ($request->filled('marca')) {
            $query->where('marca', 'like', "%{$request->input('marca')}%");
        }
        if ($request->filled('cor')) {
            $query->where('cor', 'like', "%{$request->input('cor')}%");
        }
        if ($request->filled('ano')) {
            $query->where('ano', $request->input('ano'));
        }
        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->input('cliente_id'));
        }
    
        // Executa a query e obtém os resultados
        $veiculos = $query->with('cliente')->get();
    
        // Busca todos os clientes para o dropdown
        $clientes = Cliente::all();
    
        // Busca o nome do cliente selecionado (se houver)
        $clienteSelecionado = null;
        if ($request->filled('cliente_id')) {
            $clienteSelecionado = Cliente::find($request->input('cliente_id'));
        }
    
        // Retorna a view com os resultados e a lista de clientes
        return view('veiculos.search', compact('veiculos', 'clientes', 'clienteSelecionado'));
    }

    // Exibe o formulário de edição de veículo
    public function edit($id)
    {
        $veiculo = Veiculo::findOrFail($id); // Busca o veículo pelo ID
        $clientes = Cliente::all(); // Busca todos os clientes para o formulário
        return view('veiculos.edit', compact('veiculo', 'clientes'));
    }

    // Atualiza o veículo no banco de dados
    public function update(Request $request, $id)
    {
        // Mensagens de erro personalizadas
        $messages = [
            'placa.required' => 'O campo placa é obrigatório.',
            'placa.unique' => 'Esta placa já está cadastrada.',
            'ano.min' => 'O ano deve ser maior ou igual a 1900.',
            'ano.max' => 'O ano deve ser menor ou igual ao ano atual.',
        ];

        // Validação dos dados
        $request->validate([
            'modelo' => 'required|string',
            'placa' => 'required|string|unique:veiculos,placa,' . $id, // Ignora a placa do veículo atual
            'marca' => 'required|string',
            'cor' => 'required|string',
            'ano' => 'required|integer|min:1900|max:' . date('Y'),
            'cliente_id' => 'required|exists:clientes,id',
        ], $messages);

        // Atualiza o veículo no banco de dados
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->update($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    // Exclui o veículo do banco de dados
    public function destroy($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->delete();

        return redirect()->route('veiculos.index')->with('success', 'Veículo excluído com sucesso!');
    }
}