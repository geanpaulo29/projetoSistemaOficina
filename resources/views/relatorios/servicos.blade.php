@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Relatório de Serviços') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
    <div class="container">
        <h1 class="mb-4">Relatório de Serviços</h1>

        <!-- Formulário de filtro por período -->
        <form action="{{ route('relatorios.servicos') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_inicio" value="{{ $dataInicio }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_fim" value="{{ $dataFim }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de serviços -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Veículo</th>
                    <th>Cliente</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicos as $servico)
                    <tr>
                        <td>{{ $servico->data_servico_formatada }}</td>
                        <td>{{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</td>
                        <td>{{ $servico->veiculo->cliente->nome }}</td>
                        <td>{{ $servico->descricao }}</td>
                        <td>R$ {{ number_format($servico->valor, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Faturamento total -->
        <div class="mt-4">
            <h4>Faturamento Total: R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</h4>
        </div>
    </div>
@endsection <!-- Fim da seção de conteúdo -->