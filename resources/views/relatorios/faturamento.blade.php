@extends('layouts.app')

@section('title', 'Faturamento Mensal')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Relatório de Faturamento</h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Imprimir
            </button>
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

    <x-card title="Resumo do Faturamento" class="mt-4">
        @if($faturamentoPorMes->isNotEmpty())
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total em Peças</h5>
                        <h3 class="text-primary">@money($faturamentoPorMes->sum('total_pecas'))</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Total em Mão de Obra</h5>
                        <h3 class="text-primary">@money($faturamentoPorMes->sum('total_mao_de_obra'))</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center">
                        <h5 class="card-title text-muted">Faturamento Total</h5>
                        <h3 class="text-success">@money($faturamentoPorMes->sum('total_geral'))</h3>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Mês/Ano</th>
                        <th class="text-end">Peças (R$)</th>
                        <th class="text-end">Mão de Obra (R$)</th>
                        <th class="text-end">Total (R$)</th>
                        <th class="text-end">Serviços</th>
                        <th class="text-center">Ações</th>
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
                            <td class="text-center">
                                <a href="{{ route('relatorios.faturamento.detalhes', ['ano' => $item['ano'], 'mes' => $item['mes']]) }}" 
                                   class="btn btn-sm btn-primary" title="Ver Detalhes">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Nenhum registro encontrado para o período selecionado</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($faturamentoPorMes->isNotEmpty())
                <tfoot class="table-light">
                    <tr>
                        <th>Total Geral</th>
                        <th class="text-end">@money($faturamentoPorMes->sum('total_pecas'))</th>
                        <th class="text-end">@money($faturamentoPorMes->sum('total_mao_de_obra'))</th>
                        <th class="text-end text-success">@money($faturamentoPorMes->sum('total_geral'))</th>
                        <th class="text-end">{{ $faturamentoPorMes->sum('quantidade_servicos') }}</th>
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
        .table {
            width: 100% !important;
        }
    }
</style>
@endsection