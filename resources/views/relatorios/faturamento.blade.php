@extends('layouts.app')

@section('title', 'Faturamento Mensal')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Relatório de Faturamento</h2>
        </div>
    </div>

    <x-card title="Filtros">
        <form action="{{ route('relatorios.faturamento') }}" method="GET" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="ano" class="form-label">Ano</label>
                    <select class="form-select" id="ano" name="ano">
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}" {{ $ano == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="mes" class="form-label">Mês</label>
                    <select class="form-select" id="mes" name="mes">
                        <option value="">Todos os meses</option>
                        @foreach($mesesPt as $num => $nome)
                            <option value="{{ $num }}" {{ $mes == $num ? 'selected' : '' }}>
                                {{ $nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i> Filtrar
                    </button>
                </div>
                
                <div class="col-md-2">
                    <a href="{{ route('relatorios.faturamento') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-sync-alt me-2"></i> Limpar
                    </a>
                </div>
            </div>
        </form>
    </x-card>

    <x-card title="Resultados" class="mt-4">
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th>Mês/Ano</th>
                        <th class="text-end">Peças (R$)</th>
                        <th class="text-end">Mão de Obra (R$)</th>
                        <th class="text-end">Total (R$)</th>
                        <th class="text-end">Serviços</th>
                        <th class="text-end">Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faturamentoPorMes as $item)
                        <tr>
                            <td>{{ $item['mes_nome'] }}/{{ $item['ano'] }}</td>
                            <td class="text-end">@money($item['total_pecas'])</td>
                            <td class="text-end">@money($item['total_mao_de_obra'])</td>
                            <td class="text-end fw-bold text-success">@money($item['total_geral'])</td>
                            <td class="text-end">{{ $item['quantidade_servicos'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('relatorios.faturamento.detalhes', ['ano' => $item['ano'], 'mes' => $item['mes']]) }}" 
                                   class="btn btn-sm btn-info">
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
            </table>
        </div>
    </x-card>

    <x-card title="Gráfico de Faturamento" class="mt-4">
        <div class="chart-container" style="position: relative; height: 400px;">
            <canvas id="faturamentoChart"></canvas>
        </div>
    </x-card>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('faturamentoChart').getContext('2d');
        const dados = @json($faturamentoPorMes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dados.map(item => item.label),
                datasets: [
                    {
                        label: 'Peças',
                        data: dados.map(item => item.total_pecas),
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Mão de Obra',
                        data: dados.map(item => item.total_mao_de_obra),
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL'
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(value);
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