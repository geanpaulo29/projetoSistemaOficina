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
        $clientes = Cliente::all();
        $veiculos = Veiculo::all();
        return view('servicos.create', compact('clientes', 'veiculos'));
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
        $servicos = Servico::with(['cliente', 'veiculo'])->get();
        return view('servicos.index', compact('servicos'));
    }
}