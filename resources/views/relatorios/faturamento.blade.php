@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Faturamento Mensal') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
    <div class="container">
        <h1 class="mb-4">Faturamento Mensal</h1>

        <!-- Formulário de filtro por ano -->
        <form action="{{ route('relatorios.faturamento') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="number" class="form-control" name="ano" value="{{ $ano }}" min="2000" max="{{ date('Y') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de faturamento por mês -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mês/Ano</th>
                    <th>Faturamento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faturamentoPorMes as $faturamento)
                    <tr>
                        <td>{{ $faturamento->mes }}/{{ $faturamento->ano }}</td>
                        <td>R$ {{ number_format($faturamento->total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection <!-- Fim da seção de conteúdo -->