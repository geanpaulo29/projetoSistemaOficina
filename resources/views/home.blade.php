<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
                <a class="navbar-brand" href="{{ route('home') }}"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
  <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
</svg>Home</a>

                <!-- Botões da Home -->
                <div class="navbar-nav me-auto">
                    <a href="{{ route('veiculos.create') }}" class="nav-link">Cadastrar Veículo</a>
                    <a href="{{ route('clientes.create') }}" class="nav-link">Cadastrar Cliente</a>
                    <a href="{{ route('clientes.search') }}" class="nav-link">Buscar Cliente</a>
                    <a href="{{ route('veiculos.search') }}" class="nav-link">Buscar Veículo</a>
                    <a href="{{ route('servicos.create') }}" class="nav-link">Adicionar Serviço</a>
                    <a href="{{ route('servicos.index') }}" class="nav-link">Lista de Serviços</a>
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

    <!-- Conteúdo principal -->
    <div class="center-container">
        <!-- Botão 1: Cadastrar Veículo -->
        <a href="{{ route('veiculos.create') }}" class="btn btn-primary btn-custom">
            Cadastrar Veículo
        </a>

        <!-- Botão 2: Cadastrar Cliente -->
        <a href="{{ route('clientes.create') }}" class="btn btn-success btn-custom">
            Cadastrar Cliente
        </a>

        <!-- Botão 3: Buscar Cliente -->
        <a href="{{ route('clientes.search') }}" class="btn btn-info btn-custom">
            Buscar Cliente
        </a>

        <!-- Botão 4: Buscar Veículo -->
        <a href="{{ route('veiculos.search') }}" class="btn btn-warning btn-custom">
            Buscar Veículo
        </a>

        <!-- Botão 5: Adicionar Serviço -->
        <a href="{{ route('servicos.create') }}" class="btn btn-danger btn-custom">
            Adicionar Serviço
        </a>

        <!-- Botão 6: Lista de Serviços -->
        <a href="{{ route('servicos.index') }}" class="btn btn-secondary btn-custom">
            Lista de Serviços
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>