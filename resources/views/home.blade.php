@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <!-- Cards Resumo -->
        @php
            $cards = [
                [
                    'title' => 'Clientes Cadastrados',
                    'value' => $totalClientes,
                    'icon' => 'fas fa-users',
                    'color' => 'primary'
                ],
                [
                    'title' => 'Veículos Cadastrados',
                    'value' => $totalVeiculos,
                    'icon' => 'fas fa-car',
                    'color' => 'success'
                ],
                [
                    'title' => 'Serviços Este Mês',
                    'value' => $servicosEsteMes,
                    'icon' => 'fas fa-tools',
                    'color' => 'info'
                ],
                [
                    'title' => 'Faturamento Mensal',
                    'value' => 'R$ ' . number_format($faturamentoMes, 2, ',', '.'),
                    'icon' => 'fas fa-dollar-sign',
                    'color' => 'warning'
                ]
            ];
        @endphp

        @foreach ($cards as $card)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $card['color'] }} shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-{{ $card['color'] }} text-uppercase mb-1">
                            {{ $card['title'] }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $card['value'] }}</div>
                    </div>
                    <div>
                        <i class="{{ $card['icon'] }} fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <!-- Gráfico de Serviços Mensais -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Serviços nos Últimos 6 Meses</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="servicosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimos Serviços -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Últimos Serviços</h6>
                </div>
                <div class="card-body overflow-auto" style="max-height: 320px">
                    <div class="list-group">
                        @forelse($ultimosServicos as $servico)
                        <a href="{{ route('servicos.show', $servico->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</h6>
                                <small>{{ $servico->data_servico->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($servico->descricao, 50) }}</p>
                            <small class="text-success">R$ {{ number_format($servico->valor_total, 2, ',', '.') }}</small>
                        </a>
                        @empty
                        <p class="text-muted">Nenhum serviço registrado recentemente.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ações Rápidas -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ações Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @php
                            $acoes = [
                                ['rota' => 'clientes.create', 'icone' => 'fas fa-user-plus', 'label' => 'Novo Cliente', 'cor' => 'primary'],
                                ['rota' => 'veiculos.create', 'icone' => 'fas fa-car', 'label' => 'Novo Veículo', 'cor' => 'success'],
                                ['rota' => 'servicos.create', 'icone' => 'fas fa-tools', 'label' => 'Novo Serviço', 'cor' => 'info'],
                                ['rota' => 'servicos.index', 'icone' => 'fas fa-file-invoice', 'label' => 'Lista de Serviços', 'cor' => 'warning']
                            ];
                        @endphp

                        @foreach($acoes as $acao)
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route($acao['rota']) }}" class="btn btn-{{ $acao['cor'] }} btn-circle btn-lg">
                                <i class="{{ $acao['icone'] }}"></i>
                            </a>
                            <p class="mt-2 mb-0">{{ $acao['label'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-circle {
        width: 80px;
        height: 80px;
        padding: 20px;
        border-radius: 50%;
        font-size: 26px;
        line-height: 1.33;
    }
    .chart-area {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('servicosChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($servicosMensais->pluck('mes')) !!},
                datasets: [{
                    label: 'Serviços',
                    data: {!! json_encode($servicosMensais->pluck('total')) !!},
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    fill: 'origin'
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
