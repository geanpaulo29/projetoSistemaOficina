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
        $clientes = Cliente::all(); // Busca todos os clientes para o formulário
        return view('veiculos.create', compact('clientes'));
    }

    // Salva o veículo no banco de dados
    public function store(Request $request)
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
            'placa' => 'required|string|unique:veiculos',
            'marca' => 'required|string',
            'cor' => 'required|string',
            'ano' => 'required|integer|min:1900|max:' . date('Y'),
            'cliente_id' => 'required|exists:clientes,id',
        ], $messages);

        // Cria o veículo no banco de dados
        Veiculo::create($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
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
        $veiculos = Veiculo::with('cliente')->get(); // Carrega todos os veículos para exibir na página de busca
        return view('veiculos.search', compact('veiculos'));
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