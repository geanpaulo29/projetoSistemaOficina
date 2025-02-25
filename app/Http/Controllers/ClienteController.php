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

    // Salva o cliente no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'telefone' => 'required|string',
            'cpf' => 'required|string|unique:clientes',
        ]);

        Cliente::create($request->all());

        return redirect()->route('home')->with('success', 'Cliente cadastrado com sucesso!');
    }

        // Exibe o formulário de busca de clientes
    public function search()
    {
        return view('clientes.search');
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
}