<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #f8f9fa; /* Cor de fundo da navbar */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }
        .container {
            margin-top: 80px; /* Espaço para a navbar */
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
    <div class="container">
        <h1 class="mb-4">Buscar Cliente</h1>

        <!-- Formulário de busca -->
        <form action="{{ route('clientes.find') }}" method="GET">
            <div class="mb-3">
                <label for="search" class="form-label">Nome ou CPF do Cliente</label>
                <input type="text" class="form-control" id="search" name="search" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>