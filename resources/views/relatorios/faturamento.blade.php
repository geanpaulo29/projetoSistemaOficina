<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faturamento Mensal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container {
            margin-top: 80px;
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
</body>
</html>