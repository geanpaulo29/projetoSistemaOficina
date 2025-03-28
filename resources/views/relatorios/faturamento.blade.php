@extends('layouts.app')

@section('title', 'Faturamento Mensal')

@section('content')
@php
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
@endphp

<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Relatório de Faturamento</h4>
        </div>
        <div class="card-body">
            <!-- Filtros -->
            <form action="{{ route('relatorios.faturamento') }}" method="GET" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="ano" class="form-label">Ano</label>
                        <select class="form-select" id="ano" name="ano">
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}" {{ $ano == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="mes" class="form-label">Mês (opcional)</label>
                        <select class="form-select" id="mes" name="mes">
                            <option value="">Todos os meses</option>
                            @foreach($mesesPt as $num => $nome)
                                <option value="{{ $num }}" {{ request('mes') == $num ? 'selected' : '' }}>
                                    {{ $nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('relatorios.faturamento') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-sync-alt"></i> Limpar Filtros
                        </a>
                    </div>
                </div>
            </form>

            <!-- Tabela de Resultados -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Mês/Ano</th>
                            <th>Total em Peças</th>
                            <th>Total em Mão de Obra</th>
                            <th>Faturamento Total</th>
                            <th>N° de Serviços</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faturamentoPorMes as $item)
                            <tr>
                                <td>{{ $mesesPt[$item->mes] ?? 'Mês Inválido' }}/{{ $item->ano }}</td>
                                <td>R$ {{ number_format($item->total_pecas, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format($item->total_mao_de_obra, 2, ',', '.') }}</td>
                                <td class="fw-bold">R$ {{ number_format($item->total_geral, 2, ',', '.') }}</td>
                                <td>{{ $item->quantidade_servicos }}</td>
                                <td>
                                <a href="{{ route('relatorios.faturamento.detalhes', ['ano' => $item->ano, 'mes' => $item->mes]) }}" 
                                class="btn btn-sm btn-info" title="Ver Detalhes">
                                    <i class="fas fa-search"></i>
                                </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($faturamentoPorMes->isNotEmpty())
                        <tfoot class="table-active">
                            <tr>
                                <th>Total do Período</th>
                                <th>R$ {{ number_format($faturamentoPorMes->sum('total_pecas'), 2, ',', '.') }}</th>
                                <th>R$ {{ number_format($faturamentoPorMes->sum('total_mao_de_obra'), 2, ',', '.') }}</th>
                                <th>R$ {{ number_format($faturamentoPorMes->sum('total_geral'), 2, ',', '.') }}</th>
                                <th>{{ $faturamentoPorMes->sum('quantidade_servicos') }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <!-- Gráfico -->
            <div class="mt-5">
                <canvas id="faturamentoChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('faturamentoChart').getContext('2d');
        
        // Definindo os meses em português para o JavaScript
        const mesesPtJS = {
            1: 'Janeiro',
            2: 'Fevereiro',
            3: 'Março',
            4: 'Abril',
            5: 'Maio',
            6: 'Junho',
            7: 'Julho',
            8: 'Agosto',
            9: 'Setembro',
            10: 'Outubro',
            11: 'Novembro',
            12: 'Dezembro'
        };
        
        // Preparando os dados - FORMA CORRIGIDA
        const dadosGrafico = JSON.parse('{!! json_encode($faturamentoPorMes->map(function($item) {
            return [
                "mesNum" => $item->mes,
                "ano" => $item->ano,
                "total_pecas" => $item->total_pecas,
                "total_mao_de_obra" => $item->total_mao_de_obra
            ];
        })) !!}');
        
        // Criando labels com meses em português
        const labels = dadosGrafico.map(item => {
            return (mesesPtJS[item.mesNum] || 'Mês Inválido') + '/' + item.ano;
        });
        
        // Extraindo dados para o gráfico
        const pecasData = dadosGrafico.map(item => item.total_pecas);
        const maoDeObraData = dadosGrafico.map(item => item.total_mao_de_obra);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Peças',
                        data: pecasData,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Mão de Obra',
                        data: maoDeObraData,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Faturamento Mensal (R$)'
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'R$ ' + value.toLocaleString('pt-BR');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection