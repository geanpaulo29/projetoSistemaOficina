@extends('layouts.app')

@section('title', 'Detalhes do Serviço')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Detalhes do Serviço #{{ $servico->id }}</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('servicos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
    </div>

    <x-card title="Informações do Serviço">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="text-primary mb-2">Dados do Veículo</h5>
                    <p><strong>Modelo:</strong> {{ $servico->veiculo->modelo }}</p>
                    <p><strong>Placa:</strong> {{ $servico->veiculo->placa }}</p>
                    <p><strong>Ano:</strong> {{ $servico->veiculo->ano }}</p>
                    <p><strong>Cor:</strong> {{ $servico->veiculo->cor }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="text-primary mb-2">Dados do Cliente</h5>
                    <p><strong>Nome:</strong> {{ $servico->veiculo->cliente->nome }}</p>
                    <p><strong>Telefone:</strong> {{ $servico->veiculo->cliente->telefone ?? 'Não informado' }}</p>
                    <p><strong>CPF:</strong> {{ $servico->veiculo->cliente->cpf }}</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5 class="text-primary mb-3">Informações do Serviço</h5>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Data:</strong> {{ $servico->data_servico->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Mecânico:</strong> {{ Auth::user()->name }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Status:</strong> 
                        <span class="badge bg-success">Concluído</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-4 p-3 bg-light bg-opacity-10 border border-light rounded">
            <h5 class="text-primary mb-3">Descrição do Serviço</h5>
            <p class="mb-0">{{ $servico->descricao }}</p>
        </div>

        <div class="mb-4">
            <h5 class="text-primary mb-3">Peças Utilizadas</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Peça</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-end">Valor Unitário</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servico->itens as $item)
                            <tr>
                                <td>{{ $item['nome'] }}</td>
                                <td class="text-center">{{ $item['quantidade'] }}</td>
                                <td class="text-end">R$ {{ number_format($item['valor_unitario'], 2, ',', '.') }}</td>
                                <td class="text-end">R$ {{ number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <td colspan="3" class="text-end fw-bold">Total em Peças:</td>
                            <td class="text-end fw-bold">R$ {{ number_format(collect($servico->itens)->sum(fn($item) => $item['quantidade'] * $item['valor_unitario']), 2, ',', '.') }}</td>
                        </tr>
                        <tr class="table-active">
                            <td colspan="3" class="text-end fw-bold">Mão de Obra:</td>
                            <td class="text-end fw-bold">R$ {{ number_format($servico->valor_mao_de_obra, 2, ',', '.') }}</td>
                        </tr>
                        <tr class="table-success">
                            <td colspan="3" class="text-end fw-bold">Total Geral:</td>
                            <td class="text-end fw-bold">R$ {{ number_format($servico->valor_total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('servicos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
            <a href="{{ route('ordem-servico.pdf', $servico->id) }}" class="btn btn-primary">
                <i class="fas fa-file-pdf me-2"></i> Gerar PDF
            </a>
            <a href="{{ route('servicos.edit', $servico->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i> Editar
            </a>
        </div>
    </x-card>
</div>
@endsection