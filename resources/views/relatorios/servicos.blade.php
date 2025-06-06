@extends('layouts.app')

@section('title', 'Relatório de Serviços')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Relatório de Serviços</h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Imprimir
            </button>
        </div>
    </div>

    <x-card title="Filtros">
        <form action="{{ route('relatorios.servicos') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                           value="{{ $dataInicio }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                           value="{{ $dataFim }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i> Filtrar
                    </button>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <a href="{{ route('relatorios.servicos') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-sync-alt me-2"></i> Limpar Filtros
                    </a>
                </div>
            </div>
        </form>
    </x-card>

    <x-card title="Resultados" class="mt-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Data</th>
                        <th width="20%">Cliente</th>
                        <th width="20%">Veículo</th>
                        <th width="30%">Descrição</th>
                        <th width="10%" class="text-end">Valor</th>
                        <th width="10%" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicos as $servico)
                        <tr>
                            <td>{{ $servico->data_servico->format('d/m/Y') }}</td>
                            <td>{{ $servico->veiculo->cliente->nome }}</td>
                            <td>
                                {{ $servico->veiculo->modelo }}
                                <small class="text-muted d-block">{{ $servico->veiculo->placa }}</small>
                            </td>
                            <td>
                                {{ Str::limit($servico->descricao, 100) }}
                                @if(count($servico->itens) > 0)
                                    <small class="text-muted d-block mt-1">
                                        <strong>Peças:</strong> 
                                        {{ collect($servico->itens)->pluck('nome')->implode(', ') }}
                                    </small>
                                @endif
                            </td>
                            <td class="text-end fw-bold text-success">
                                R$ {{ number_format($servico->valor_total, 2, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('servicos.show', $servico->id) }}" 
                                   class="btn btn-sm btn-primary" title="Ver Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Nenhum serviço encontrado no período selecionado</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="text-end">Total no Período:</th>
                        <th class="text-end fw-bold text-primary">
                            R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}
                        </th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-end">Quantidade de Serviços:</th>
                        <th class="text-end fw-bold">{{ $servicos->count() }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>

        @if($servicos->count() > 0)
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Resumo Financeiro</h5>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>Total em Peças:</span>
                                <strong>R$ {{ number_format($servicos->sum(function($s) { 
                                    return collect($s->itens)->sum(function($i) { 
                                        return $i['quantidade'] * $i['valor_unitario']; 
                                    }); 
                                }), 2, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span>Total em Mão de Obra:</span>
                                <strong>R$ {{ number_format($servicos->sum('valor_mao_de_obra'), 2, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2">
                                <span>Total Geral:</span>
                                <strong class="text-success">R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Distribuição por Veículo</h5>
                            <ul class="list-group list-group-flush">
                                @foreach($servicos->groupBy('veiculo_id') as $veiculoServicos)
                                    @php $veiculo = $veiculoServicos->first()->veiculo; @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $veiculo->modelo }} ({{ $veiculo->placa }})
                                        <span class="badge bg-primary rounded-pill">
                                            {{ $veiculoServicos->count() }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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