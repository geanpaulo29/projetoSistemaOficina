@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Estatísticas de Clientes') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
    <div class="container">
        <h1 class="mb-4">Estatísticas de Clientes</h1>

        <!-- Clientes cadastrados por mês -->
        <h3 class="mt-4">Clientes Cadastrados por Mês</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Mês/Ano</th>
                    <th>Total de Clientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientesPorMes as $cliente)
                    <tr>
                        <td>{{ $cliente->mes }}/{{ $cliente->ano }}</td>
                        <td>{{ $cliente->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Veículos por cliente -->
        <h3 class="mt-4">Veículos por Cliente</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Total de Veículos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($veiculosPorCliente as $cliente)
                    <tr>
                        <td>{{ $cliente->nome }}</td>
                        <td>{{ $cliente->veiculos_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection <!-- Fim da seção de conteúdo -->