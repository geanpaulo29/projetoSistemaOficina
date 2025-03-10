<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title> <!-- Título dinâmico -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            width: 150px; /* Largura dos botões */
            height: 300px; /* Altura dos botões */
            margin: 10px; /* Espaçamento entre os botões */
            font-size: 20px; /* Tamanho da fonte */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column; /* Organiza o conteúdo verticalmente */
            text-align: center; /* Centraliza o texto horizontalmente */
        }
        .navbar-custom {
            background-color: #f8f9fa; /* Cor de fundo da navbar */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 56px); /* Altura total da viewport menos a altura da navbar */
            margin-top: 56px; /* Espaço para a navbar */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
        <div class="container-fluid">
            <!-- Botão para voltar à home -->
            <a class="navbar-brand" href="{{ route('home') }}">Home</a>

            <!-- Botões da Home -->
                <div class="navbar-nav me-auto">
                <a href="{{ route('veiculos.create') }}" class="nav-link">Cadastrar Veículo</a>
                <a href="{{ route('clientes.create') }}" class="nav-link">Cadastrar Cliente</a>
                <a href="{{ route('clientes.search') }}" class="nav-link">Buscar Cliente</a>
                <a href="{{ route('veiculos.search') }}" class="nav-link">Buscar Veículo</a>
                <a href="{{ route('servicos.create') }}" class="nav-link">Adicionar Serviço</a>
                <a href="{{ route('servicos.index') }}" class="nav-link">Lista de Serviços</a>
                <a href="{{ route('relatorios.servicos') }}" class="nav-link">Relatório de Serviços</a>
                <a href="{{ route('relatorios.clientes') }}" class="nav-link">Estatísticas de Clientes</a>
                <a href="{{ route('relatorios.faturamento') }}" class="nav-link">Faturamento Mensal</a>
                <a href="{{ route('configuracoes.edit') }}" class="nav-link">Configurações</a>
            </div>

            <!-- Botão de Logout -->
            <div class="ms-auto">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="py-4" style="margin-top: 80px">
        @yield('content') <!-- Conteúdo dinâmico das páginas -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>