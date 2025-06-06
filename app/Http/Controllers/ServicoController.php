<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Veiculo;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Traits\Filterable;

class ServicoController extends Controller
{
    use Filterable;

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
            'valor_mao_de_obra' => 'required|numeric|min:0',
            'itens' => 'nullable|array',
            'itens.*.nome' => 'required|string',
            'itens.*.quantidade' => 'required|numeric|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'data_servico' => 'required|date',
        ]);
    
        // Calcula o valor total dos itens
        $itens = collect($request->itens)->map(function ($item) {
            $item['valor_total'] = $item['quantidade'] * $item['valor_unitario'];
            return $item;
        });
    
        // Cria o serviço com os itens em JSON
        $servico = Servico::create([
            'veiculo_id' => $request->veiculo_id,
            'descricao' => $request->descricao,
            'valor_mao_de_obra' => $request->valor_mao_de_obra,
            'itens' => $itens,
            'valor_total' => $request->valor_total, // Já calculado pelo JavaScript
            'data_servico' => $request->data_servico,
        ]);
    
        return redirect()->route('servicos.index')->with('success', 'Serviço cadastrado com sucesso!');
    }
    public function show($id)
    {
        $servico = Servico::with(['veiculo.cliente'])->findOrFail($id);
        return view('servicos.show', compact('servico'));
    }

    // Lista todos os serviços com paginação e filtros
    public function index(Request $request)
    {
        // Query base para serviços
        $query = Servico::with(['veiculo.cliente']);

        // Filtro por termo de busca global
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'like', "%$search%")
                  ->orWhereHas('veiculo', function ($q) use ($search) {
                      $q->where('placa', 'like', "%$search%")
                        ->orWhere('modelo', 'like', "%$search%")
                        ->orWhereHas('cliente', function ($q) use ($search) {
                            $q->where('nome', 'like', "%$search%");
                        });
                  });
            });
        }

        // Filtro por placa
        if ($request->filled('placa')) {
            $placa = $request->input('placa');
            $query->whereHas('veiculo', function ($q) use ($placa) {
                $q->where('placa', 'like', "%$placa%");
            });
        }

        // Filtro por modelo
        if ($request->filled('modelo')) {
            $modelo = $request->input('modelo');
            $query->whereHas('veiculo', function ($q) use ($modelo) {
                $q->where('modelo', 'like', "%$modelo%");
            });
        }

        // Filtro por cliente
        if ($request->filled('cliente')) {
            $cliente = $request->input('cliente');
            $query->whereHas('veiculo.cliente', function ($q) use ($cliente) {
                $q->where('nome', 'like', "%$cliente%");
            });
        }

        // Filtro por data (período)
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data_servico', [
                $request->input('data_inicio'),
                $request->input('data_fim')
            ]);
        }

        // Filtro por valor mínimo
        if ($request->filled('valor_minimo')) {
            $query->where('valor', '>=', $request->input('valor_minimo'));
        }

        // Ordenação
        $sortField = $request->input('ordenar_por', 'data_servico'); // Campo padrão para ordenação
        $sortDirection = $request->input('direcao', 'desc'); // Direção padrão para ordenação
        $query = $this->applySorting($query, $sortField, $sortDirection);

        // Paginação
        $servicos = $query->paginate(10);

        return view('servicos.index', compact('servicos'));
    }

    // Exibe o formulário de edição de serviço
    public function edit($id)
    {
        $servico = Servico::findOrFail($id);
        $veiculos = Veiculo::with('cliente')->get();
        return view('servicos.edit', compact('servico', 'veiculos'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'descricao' => 'required|string',
            'valor_mao_de_obra' => 'required|numeric|min:0',
            'itens' => 'nullable|array',
            'itens.*.nome' => 'required|string',
            'itens.*.quantidade' => 'required|numeric|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'data_servico' => 'required|date',
        ]);
    
        $servico = Servico::findOrFail($id);
    
        // Calcula valores totais
        $itens = collect($request->itens)->map(function ($item) {
            $item['valor_total'] = $item['quantidade'] * $item['valor_unitario'];
            return $item;
        });
    
        $servico->update([
            'veiculo_id' => $request->veiculo_id,
            'descricao' => $request->descricao,
            'valor_mao_de_obra' => $request->valor_mao_de_obra,
            'itens' => $itens,
            'valor_total' => $request->valor_total,
            'data_servico' => $request->data_servico,
        ]);
    
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