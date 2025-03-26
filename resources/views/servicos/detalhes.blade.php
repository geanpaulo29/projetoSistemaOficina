@extends('layouts.app')

@section('title', 'Detalhes do Serviço')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detalhes do Serviço #{{ $servico->id }}</h4>
        </div>
        <div class="card-body">
            <!-- Dados Básicos -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Data:</strong> {{ $servico->data_servico->format('d/m/Y') }}</p>
                    <p><strong>Cliente:</strong> {{ $servico->veiculo->cliente->nome }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Veículo:</strong> {{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</p>
                    <p><strong>Mecânico:</strong> {{ Auth::user()->name }}</p>
                </div>
            </div>

            <!-- Descrição -->
            <div class="mb-4 p-3 bg-light rounded">
                <h5>Descrição do Serviço</h5>
                <p>{{ $servico->descricao }}</p>
            </div>

            <!-- Itens do Serviço -->
            <h5 class="mt-4">Peças Utilizadas</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Peça</th>
                        <th>Quantidade</th>
                        <th>Valor Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servico->itens as $item)
                        <tr>
                            <td>{{ $item['nome'] }}</td>
                            <td>{{ $item['quantidade'] }}</td>
                            <td>R$ {{ number_format($item['valor_unitario'], 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-active">
                        <td colspan="3" class="text-end"><strong>Total em Peças:</strong></td>
                        <td>R$ {{ number_format(collect($servico->itens)->sum(fn($item) => $item['quantidade'] * $item['valor_unitario']), 2, ',', '.') }}</td>
                    </tr>
                    <tr class="table-active">
                        <td colspan="3" class="text-end"><strong>Mão de Obra:</strong></td>
                        <td>R$ {{ number_format($servico->valor_mao_de_obra, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="3" class="text-end"><strong>Total Geral:</strong></td>
                        <td>R$ {{ number_format($servico->valor_total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-4">
                <a href="{{ route('servicos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <a href="{{ route('ordem-servico.pdf', $servico->id) }}" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Gerar PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection