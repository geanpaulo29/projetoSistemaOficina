<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use App\Models\Cliente;

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
    public function index(Request $request)
    {
        // Filtros
        $query = Servico::with(['veiculo.cliente']);
    
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
        if ($request->has('ordenar_por') && $request->has('direcao')) {
            $query->orderBy($request->input('ordenar_por'), $request->input('direcao'));
        } else {
            $query->orderBy('data_servico', 'desc'); // Ordenação padrão por data (mais recente primeiro)
        }
    
        // Paginação
        $servicos = $query->paginate(10);
    
        return view('servicos.index', compact('servicos'));
    }
    
    public function find(Request $request)
    {
        // Filtros
        $query = Servico::with(['veiculo.cliente']);
    
        // Filtro por termo de busca
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('descricao', 'like', "%$search%")
                  ->orWhere('valor', 'like', "%$search%")
                  ->orWhere('data_servico', 'like', "%$search%")
                  ->orWhereHas('veiculo', function ($q) use ($search) {
                      $q->where('placa', 'like', "%$search%")
                        ->orWhere('modelo', 'like', "%$search%");
                  })
                  ->orWhereHas('veiculo.cliente', function ($q) use ($search) {
                      $q->where('nome', 'like', "%$search%");
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
        if ($request->has('ordenar_por') && $request->has('direcao')) {
            $query->orderBy($request->input('ordenar_por'), $request->input('direcao'));
        } else {
            $query->orderBy('data_servico', 'desc'); // Ordenação padrão por data (mais recente primeiro)
        }
    
        // Paginação
        $servicos = $query->paginate(10);
    
        return view('servicos.index', compact('servicos'));
    }


    // Exibe o formulário de busca de serviços
    public function search()
    {
        $servicos = Servico::with(['veiculo.cliente'])->get(); // Carrega todos os serviços para exibir na página de busca
        return view('servicos.search', compact('servicos'));
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
        // Gera a ordem de serviço
    public function gerarOrdemServico($id)
    {
        $servico = Servico::with('veiculo.cliente')->findOrFail($id); // Busca o serviço com relacionamentos
        $configuracao = Configuracao::first(); // Busca as configurações da oficina

        return view('ordem_servico.show', compact('servico', 'configuracao'));
    }
    
}