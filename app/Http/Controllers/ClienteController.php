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

        // Exibe o formulário de busca de clientes
    public function search()
    {
        $clientes = Cliente::all(); // Busca todos os clientes cadastrados
        return view('clientes.search', compact('clientes'));
    }

    // Processa a busca de clientes
    public function find(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);
    
        $search = $request->input('search');
    
        // Busca clientes pelo nome ou CPF
        $clientes = Cliente::where('nome', 'like', "%$search%")
            ->orWhere('cpf', 'like', "%$search%")
            ->get();
    
        return view('clientes.results', compact('clientes'));
    }
    //Adiciona edição
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
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

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.search')->with('success', 'Cliente excluído com sucesso!');
    }
    
}