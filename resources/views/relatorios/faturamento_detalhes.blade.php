@extends('layouts.app')

@section('title', 'Detalhes do Faturamento')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Detalhes do Faturamento - {{ $nomeMes }}/{{ $ano }}</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('relatorios.faturamento') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Imprimir
            </button>
        </div>
    </div>

    <x-card title="Resumo Mensal">
        @if($servicos->isNotEmpty())
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total em Peças</h5>
                        <h3 class="text-primary">
                            @php
                                $totalPecas = $servicos->sum(function($s) { 
                                    return collect($s->itens)->sum(fn($i) => $i['quantidade'] * $i['valor_unitario']); 
                                });
                            @endphp
                            @money($totalPecas)
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total em Mão de Obra</h5>
                        <h3 class="text-primary">@money($servicos->sum('valor_mao_de_obra'))</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Faturamento Total</h5>
                        <h3 class="text-success">@money($servicos->sum('valor_total'))</h3>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Veículo</th>
                        <th class="text-end">Peças (R$)</th>
                        <th class="text-end">Mão de Obra (R$)</th>
                        <th class="text-end">Total (R$)</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicos as $servicoItem)
                        @php
                            $totalPecas = collect($servicoItem->itens)->sum(function($item) {
                                return $item['quantidade'] * $item['valor_unitario'];
                            });
                        @endphp
                        <tr>
                            <td>{{ $servicoItem->data_servico->format('d/m/Y') }}</td>
                            <td>{{ $servicoItem->veiculo->cliente->nome }}</td>
                            <td>
                                {{ $servicoItem->veiculo->modelo }}
                                <small class="text-muted d-block">{{ $servicoItem->veiculo->placa }}</small>
                            </td>
                            <td class="text-end">@money($totalPecas)</td>
                            <td class="text-end">@money($servicoItem->valor_mao_de_obra)</td>
                            <td class="text-end fw-bold text-success">@money($servicoItem->valor_total)</td>
                            <td class="text-center">
                                <a href="{{ route('ordem-servico.pdf', $servicoItem->id) }}" 
                                   class="btn btn-sm btn-primary" title="Gerar PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('servicos.show', $servicoItem->id) }}" 
                                   class="btn btn-sm btn-info" title="Ver Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @if($servicos->isNotEmpty())
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3">Total</th>
                        <th class="text-end">@money($totalPecas)</th>
                        <th class="text-end">@money($servicos->sum('valor_mao_de_obra'))</th>
                        <th class="text-end text-success">@money($servicos->sum('valor_total'))</th>
                        <th></th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </x-card>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .card, .card * {
            visibility: visible;
        }
        .card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }
        .no-print {
            display: none !important;
        }
    }
</style>
@endsection