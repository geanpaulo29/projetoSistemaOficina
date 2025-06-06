@extends('layouts.app')

@section('title', 'Ordem de Serviço')

@section('content')
    <div class="container">
        <div class="text-center mb-4">
            @if ($configuracao->logo_oficina ?? false)
                <img src="{{ asset('storage/' . $configuracao->logo_oficina) }}" alt="Logo da Oficina" style="max-width: 150px;">
            @endif
            <h1>{{ $configuracao->nome_oficina ?? 'Nome da Oficina' }}</h1>
            <h2>Ordem de Serviço</h2>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h3>Detalhes do Serviço</h3>
                <p><strong>Data:</strong> {{ $servico->data_servico->format('d/m/Y') }}</p>
                <p><strong>Cliente:</strong> {{ $servico->veiculo->cliente->nome }}</p>
                <p><strong>Veículo:</strong> {{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</p>
                <p><strong>Descrição:</strong> {{ $servico->descricao }}</p>
                <p><strong>Valor:</strong> R$ {{ number_format($servico->valor, 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none;
            }
            .card {
                border: none;
                box-shadow: none;
            }
        }
    </style>
@endsection