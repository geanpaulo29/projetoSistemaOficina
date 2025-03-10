@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Home') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
    <div class="center-container">
        <!-- Botão 1: Cadastrar Veículo -->
        <a href="{{ route('veiculos.create') }}" class="btn btn-primary btn-custom">
            Cadastrar Veículo
        </a>

        <!-- Botão 4: Buscar Veículo -->
        <a href="{{ route('veiculos.search') }}" class="btn btn-primary btn-custom">
            Buscar Veículo
        </a>

        <!-- Botão 2: Cadastrar Cliente -->
        <a href="{{ route('clientes.create') }}" class="btn btn-warning btn-custom">
            Cadastrar Cliente
        </a>

        <!-- Botão 3: Buscar Cliente -->
        <a href="{{ route('clientes.search') }}" class="btn btn-warning btn-custom">
            Buscar Cliente
        </a>

        <!-- Botão 7: Estatísticas de clientes -->
        <a href="{{ route('relatorios.clientes') }}" class="btn btn-warning btn-custom">
            Estatísticas de Clientes
        </a>

        <!-- Botão 5: Adicionar Serviço -->
        <a href="{{ route('servicos.create') }}" class="btn btn-danger btn-custom">
            Adicionar Serviço
        </a>

        <!-- Botão 6: Lista de Serviços -->
        <a href="{{ route('servicos.index') }}" class="btn btn-danger btn-custom">
            Lista de Serviços
        </a>

        <!-- Botão 7: Relatorio de Serviços -->
         <a href="{{ route('relatorios.servicos') }}" class="btn btn-danger btn-custom">
            Relatorio de Serviços
        </a>

        <!-- Botão 7: Faturamento Mensal -->
        <a href="{{ route('relatorios.faturamento') }}" class="btn btn-success btn-custom">
            Faturamento Mensal
        </a>
    </div>
@endsection <!-- Fim da seção de conteúdo -->