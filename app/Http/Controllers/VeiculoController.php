<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Cliente; // Importe o model Cliente
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    // Exibe o formulário de cadastro de veículo
    public function create()
    {
        $clientes = Cliente::all(); // Busca todos os clientes
        return view('veiculos.create', compact('clientes'));
    }

    // Exibe a lista de veículos
    public function index()
    {
        $veiculos = Veiculo::with('cliente')->get(); // Carrega os veículos com seus clientes
        return view('veiculos.index', compact('veiculos'));
    }

    // Salva o veículo no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string',
            'placa' => 'required|string|unique:veiculos',
            'marca' => 'required|string',
            'cor' => 'required|string',
            'ano' => 'required|integer',
            'cliente_id' => 'required|exists:clientes,id', // Valida o cliente_id
        ]);

        Veiculo::create($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    // Exibe o formulário de busca de veículos
    public function search()
    {
        return view('veiculos.search');
    }

    // Processa a busca de veículos
    public function find(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $search = $request->input('search');

        // Busca veículos pelo modelo, placa ou marca
        $veiculos = Veiculo::where('modelo', 'like', "%$search%")
            ->orWhere('placa', 'like', "%$search%")
            ->orWhere('marca', 'like', "%$search%")
            ->get();

        return view('veiculos.results', compact('veiculos'));
    }
}