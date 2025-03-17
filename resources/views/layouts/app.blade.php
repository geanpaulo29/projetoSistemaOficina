<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: #333;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover {
            color: #007bff;
        }
        .nav-link i {
            margin-right: 8px; /* Espaçamento entre o ícone e o texto */
        }
        .btn-custom {
            width: 150px;
            height: 150px;
            margin: 10px;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .center-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 56px);
            margin-top: 56px;
            flex-wrap: wrap;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .back-arrow {
            position: fixed;
            top: 120px;
            left: 30px;
            z-index: 1000;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s;
        }
        .back-arrow:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-home"></i> Home
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a href="{{ route('veiculos.create') }}" class="nav-link">
                        <i class="fas fa-car"></i> Cadastrar Veículo
                    </a>
                    <a href="{{ route('clientes.create') }}" class="nav-link">
                        <i class="fas fa-user-plus"></i> Cadastrar Cliente
                    </a>
                    <a href="{{ route('clientes.search') }}" class="nav-link">
                        <i class="fas fa-search"></i> Buscar Cliente
                    </a>
                    <a href="{{ route('veiculos.search') }}" class="nav-link">
                        <i class="fas fa-search"></i> Buscar Veículo
                    </a>
                    <a href="{{ route('servicos.create') }}" class="nav-link">
                        <i class="fas fa-tools"></i> Adicionar Serviço
                    </a>
                    <a href="{{ route('servicos.index') }}" class="nav-link">
                        <i class="fas fa-list"></i> Lista de Serviços
                    </a>
                    <a href="{{ route('relatorios.servicos') }}" class="nav-link">
                        <i class="fas fa-file-alt"></i> Relatório de Serviços
                    </a>
                    <a href="{{ route('relatorios.clientes') }}" class="nav-link">
                        <i class="fas fa-chart-line"></i> Estatísticas de Clientes
                    </a>
                    <a href="{{ route('relatorios.faturamento') }}" class="nav-link">
                        <i class="fas fa-dollar-sign"></i> Faturamento Mensal
                    </a>
                    <a href="{{ route('configuracoes.edit') }}" class="nav-link">
                        <i class="fas fa-cog"></i> Configurações
                    </a>
                </div>
                <div class="ms-auto">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Botão de Voltar -->
    <a href="javascript:history.back()" class="back-arrow">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- Conteúdo Principal -->
    <main class="py-4" style="margin-top: 80px">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>