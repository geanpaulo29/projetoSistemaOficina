@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="center-container">
        <a href="{{ route('veiculos.create') }}" class="btn btn-primary btn-custom">
            <i class="fas fa-car fa-3x mb-2"></i>
            Cadastrar Veículo
        </a>
        <a href="{{ route('veiculos.index') }}" class="btn btn-primary btn-custom">
            <i class="fas fa-search fa-3x mb-2"></i>
            Buscar Veículo
        </a>
        <a href="{{ route('clientes.create') }}" class="btn btn-warning btn-custom">
            <i class="fas fa-user-plus fa-3x mb-2"></i>
            Cadastrar Cliente
        </a>
        <a href="{{ route('clientes.index') }}" class="btn btn-warning btn-custom">
            <i class="fas fa-search fa-3x mb-2"></i>
            Buscar Cliente
        </a>
        <a href="{{ route('relatorios.clientes') }}" class="btn btn-warning btn-custom">
            <i class="fas fa-chart-line fa-3x mb-2"></i>
            Estatísticas de Clientes
        </a>
        <a href="{{ route('servicos.create') }}" class="btn btn-danger btn-custom">
            <i class="fas fa-tools fa-3x mb-2"></i>
            Adicionar Serviço
        </a>
        <a href="{{ route('servicos.index') }}" class="btn btn-danger btn-custom">
            <i class="fas fa-list fa-3x mb-2"></i>
            Lista de Serviços
        </a>
        <a href="{{ route('relatorios.servicos') }}" class="btn btn-danger btn-custom">
            <i class="fas fa-file-alt fa-3x mb-2"></i>
            Relatório de Serviços
        </a>
        <a href="{{ route('relatorios.faturamento') }}" class="btn btn-success btn-custom">
            <i class="fas fa-dollar-sign fa-3x mb-2"></i>
            Faturamento Mensal
        </a>
    </div>
@endsection