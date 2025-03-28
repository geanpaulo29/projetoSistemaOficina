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
        $ano = $request->input('ano', date('Y'));
        $mes = $request->input('mes');
    
        // Primeiro obtemos os serviços filtrados
        $query = Servico::query()
            ->whereYear('data_servico', $ano)
            ->orderBy('data_servico', 'desc');
    
        if ($mes) {
            $query->whereMonth('data_servico', $mes);
        }
    
        $servicos = $query->get();
    
        // Agrupamos manualmente por mês/ano
        $faturamentoPorMes = $servicos->groupBy(function ($item) {
            return $item->data_servico->format('Y-m');
        })->map(function ($group) {
            $totalPecas = $group->sum(function ($servico) {
                return collect($servico->itens)->sum(function ($item) {
                    return $item['quantidade'] * $item['valor_unitario'];
                });
            });
    
            return (object) [
                'ano' => $group->first()->data_servico->format('Y'),
                'mes' => $group->first()->data_servico->format('m'),
                'total_pecas' => $totalPecas,
                'total_mao_de_obra' => $group->sum('valor_mao_de_obra'),
                'total_geral' => $group->sum('valor_total'),
                'quantidade_servicos' => $group->count()
            ];
        })->sortByDesc(function ($item) {
            return $item->ano . $item->mes;
        })->values();
    
        return view('relatorios.faturamento', [
            'faturamentoPorMes' => $faturamentoPorMes,
            'ano' => $ano,
            'mes' => $mes
        ]);
    }

    // Detalhes do faturamento mensal
    public function faturamentoDetalhes($ano, $mes)
    {
        $mesesPt = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        $servicos = Servico::with(['veiculo.cliente'])
            ->whereYear('data_servico', $ano)
            ->whereMonth('data_servico', $mes)
            ->orderBy('data_servico', 'desc')
            ->get();

        return view('relatorios.faturamento_detalhes', [
            'servicos' => $servicos,
            'ano' => $ano,
            'mes' => $mes,
            'nomeMes' => $mesesPt[$mes] ?? 'Mês Inválido'
        ]);
    }
}