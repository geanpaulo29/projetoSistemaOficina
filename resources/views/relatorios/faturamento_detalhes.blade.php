@extends('layouts.app')

@section('title', 'Detalhes do Faturamento')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                Detalhes do Faturamento - {{ $nomeMes }}/{{ $ano }}
                <a href="{{ route('relatorios.faturamento') }}" class="btn btn-sm btn-light float-end">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Veículo</th>
                            <th>Cliente</th>
                            <th>Peças (R$)</th>
                            <th>Mão de Obra (R$)</th>
                            <th>Total (R$)</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servicos as $servico)
                            @php
                                $totalPecas = collect($servico->itens)->sum(function($item) {
                                    return $item['quantidade'] * $item['valor_unitario'];
                                });
                            @endphp
                            <tr>
                                <td>{{ $servico->data_servico->format('d/m/Y') }}</td>
                                <td>{{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</td>
                                <td>{{ $servico->veiculo->cliente->nome }}</td>
                                <td>{{ number_format($totalPecas, 2, ',', '.') }}</td>
                                <td>{{ number_format($servico->valor_mao_de_obra, 2, ',', '.') }}</td>
                                <td>{{ number_format($servico->valor_total, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('ordem-servico.pdf', $servico->id) }}" 
                                       class="btn btn-sm btn-info" title="Gerar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum serviço encontrado</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($servicos->isNotEmpty())
                        <tfoot class="table-active">
                            <tr>
                                <th colspan="3">Total</th>
                                <th>{{ number_format($servicos->sum(function($s) {
                                    return collect($s->itens)->sum(fn($i) => $i['quantidade'] * $i['valor_unitario']);
                                }), 2, ',', '.') }}</th>
                                <th>{{ number_format($servicos->sum('valor_mao_de_obra'), 2, ',', '.') }}</th>
                                <th>{{ number_format($servicos->sum('valor_total'), 2, ',', '.') }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection