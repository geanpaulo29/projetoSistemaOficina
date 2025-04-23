<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Cliente;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    // Exibe o formulário de cadastro de veículo
    public function create()
    {
        $clientes = Cliente::all();
        return view('veiculos.create', compact('clientes'));
    }

    // Lista todos os veículos com paginação
    public function index()
    {
        $veiculos = Veiculo::with('cliente')->paginate(10);
        return view('veiculos.index', compact('veiculos'));
    }

    // Exibe o formulário de busca de veículos
    public function search()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $veiculos = Veiculo::paginate(10); // Adicione esta linha
        
        return view('veiculos.search', compact('clientes', 'veiculos'));
    }
    

    // Processa a busca de veículos
    public function find(Request $request)
    {
        $query = Veiculo::query()->with('cliente');

        // Aplica filtros
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('modelo', 'like', "%$search%")
                ->orWhere('placa', 'like', "%$search%")
                ->orWhere('marca', 'like', "%$search%");
            });
        }

        if ($request->filled('placa')) {
            $query->where('placa', 'like', "%{$request->placa}%");
        }

        if ($request->filled('modelo')) {
            $query->where('modelo', 'like', "%{$request->modelo}%");
        }

        if ($request->filled('cor')) {
            $query->where('cor', 'like', "%{$request->cor}%");
        }

        if ($request->filled('ano')) {
            $query->where('ano', $request->ano);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        // Paginação com 10 itens por página

        $veiculos = $query->paginate(10)->appends($request->query());
        $clientes = Cliente::orderBy('nome')->get();

        return view('veiculos.results', compact('veiculos', 'clientes'));
    }

    // Salva o veículo no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string',
            'placa' => 'required|string|unique:veiculos',
            'marca' => 'required|string',
            'cor' => 'required|string',
            'ano' => 'required|integer|min:1900|max:' . date('Y'),
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        Veiculo::create($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    // Exibe o formulário de edição de veículo
    public function edit($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $clientes = Cliente::all();
        return view('veiculos.edit', compact('veiculo', 'clientes'));
    }

    // Atualiza o veículo no banco de dados
    public function update(Request $request, $id)
    {
        $request->validate([
            'modelo' => 'required|string',
            'placa' => 'required|string|unique:veiculos,placa,' . $id,
            'marca' => 'required|string',
            'cor' => 'required|string',
            'ano' => 'required|integer|min:1900|max:' . date('Y'),
            'cliente_id' => 'required|exists:clientes,id',
        ]);

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