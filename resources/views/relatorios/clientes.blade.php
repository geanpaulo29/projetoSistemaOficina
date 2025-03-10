<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas de Clientes</title>
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
</body>
</html>