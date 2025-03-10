<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    // Relatório de serviços por período
    public function servicos(Request $request)
    {
        // Filtros
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        // Query base
        $query = Servico::query();

        // Aplica filtros de data
        if ($dataInicio && $dataFim) {
            $query->whereBetween('data_servico', [$dataInicio, $dataFim]);
        }

        // Executa a query
        $servicos = $query->with('veiculo.cliente')->get();

        // Calcula o faturamento total
        $faturamentoTotal = $servicos->sum('valor');

        return view('relatorios.servicos', compact('servicos', 'faturamentoTotal', 'dataInicio', 'dataFim'));
    }

    // Estatísticas de clientes
    public function clientes()
    {
        // Número de clientes cadastrados por mês
        $clientesPorMes = Cliente::selectRaw('YEAR(created_at) as ano, MONTH(created_at) as mes, COUNT(*) as total')
            ->groupBy('ano', 'mes')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        // Quantidade de veículos por cliente
        $veiculosPorCliente = Cliente::withCount('veiculos')->get();

        return view('relatorios.clientes', compact('clientesPorMes', 'veiculosPorCliente'));
    }

    // Faturamento mensal
    public function faturamento(Request $request)
    {
        // Filtros
        $ano = $request->input('ano', date('Y')); // Ano atual por padrão

        // Query base
        $faturamentoPorMes = Servico::selectRaw('YEAR(data_servico) as ano, MONTH(data_servico) as mes, SUM(valor) as total')
            ->whereYear('data_servico', $ano)
            ->groupBy('ano', 'mes')
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        return view('relatorios.faturamento', compact('faturamentoPorMes', 'ano'));
    }
}