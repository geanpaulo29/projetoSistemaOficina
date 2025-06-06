<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Exibe o formulário de cadastro de cliente
    public function create()
    {
        return view('clientes.create');
    }

    // Lista todos os clientes com paginação
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    // Exibe o formulário de busca de clientes
    public function search()
    {
        $clientes = Cliente::paginate(10);
        return view('clientes.search', compact('clientes'));
    }

    // Processa a busca de clientes
    public function find(Request $request)
    {
        $query = Cliente::query();

        // Filtro por termo de busca geral
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%$search%")
                  ->orWhere('cpf', 'like', "%$search%")
                  ->orWhere('telefone', 'like', "%$search%")
                  ->orWhere('cidade', 'like', "%$search%")
                  ->orWhere('bairro', 'like', "%$search%")
                  ->orWhere('rua', 'like', "%$search%")
                  ->orWhere('numero', 'like', "%$search%");
            });
        }

        // Filtros avançados
        if ($request->filled('cidade')) {
            $query->where('cidade', 'like', "%{$request->input('cidade')}%");
        }
        if ($request->filled('bairro')) {
            $query->where('bairro', 'like', "%{$request->input('bairro')}%");
        }
        if ($request->filled('rua')) {
            $query->where('rua', 'like', "%{$request->input('rua')}%");
        }
        if ($request->filled('numero')) {
            $query->where('numero', 'like', "%{$request->input('numero')}%");
        }

        // Paginação
        $clientes = $query->paginate(10);

        return view('clientes.search', compact('clientes'));
    }

    // Salva o cliente no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'cpf' => 'required|string|unique:clientes',
            'cidade' => 'required|string',
            'bairro' => 'required|string',
            'rua' => 'required|string',
            'numero' => 'required|string',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.search')->with('success', 'Cliente cadastrado com sucesso!');
    }

    // Exibe o formulário de edição de cliente
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    // Atualiza o cliente no banco de dados
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string',
            'telefone' => 'required|string',
            'cpf' => 'required|string|unique:clientes,cpf,' . $id,
            'cidade' => 'required|string',
            'bairro' => 'required|string',
            'rua' => 'required|string',
            'numero' => 'required|string',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.search')->with('success', 'Cliente atualizado com sucesso!');
    }

    // Exclui o cliente do banco de dados
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.search')->with('success', 'Cliente excluído com sucesso!');
    }
}