@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Ordem de Serviço') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
    <div class="container">
        <!-- Cabeçalho da Ordem de Serviço -->
        <div class="text-center">
            @if ($configuracao->logo_oficina ?? false)
                <img src="{{ asset('storage/' . $configuracao->logo_oficina) }}" alt="Logo da Oficina" style="max-width: 150px;">
            @endif
            <h1>{{ $configuracao->nome_oficina ?? 'Nome da Oficina' }}</h1>
            <h2>Ordem de Serviço</h2>
        </div>

        <!-- Detalhes do Serviço -->
        <div class="mt-4">
            <h3>Detalhes do Serviço</h3>
            <p><strong>Data:</strong> {{ $servico->data_servico->format('d/m/Y') }}</p>
            <p><strong>Cliente:</strong> {{ $servico->veiculo->cliente->nome }}</p>
            <p><strong>Veículo:</strong> {{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</p>
            <p><strong>Descrição:</strong> {{ $servico->descricao }}</p>
            <p><strong>Valor:</strong> R$ {{ number_format($servico->valor, 2, ',', '.') }}</p>
        </div>

        <!-- Botão de Impressão -->
        <div class="mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
        </div>
    </div>
@endsection <!-- Fim da seção de conteúdo -->