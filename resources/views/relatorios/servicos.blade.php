<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Serviços</title>
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
        <h1 class="mb-4">Relatório de Serviços</h1>

        <!-- Formulário de filtro por período -->
        <form action="{{ route('relatorios.servicos') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_inicio" value="{{ $dataInicio }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_fim" value="{{ $dataFim }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de serviços -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Veículo</th>
                    <th>Cliente</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicos as $servico)
                    <tr>
                        <td>{{ $servico->data_servico_formatada }}</td>
                        <td>{{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</td>
                        <td>{{ $servico->veiculo->cliente->nome }}</td>
                        <td>{{ $servico->descricao }}</td>
                        <td>R$ {{ number_format($servico->valor, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Faturamento total -->
        <div class="mt-4">
            <h4>Faturamento Total: R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</h4>
        </div>
    </div>
</body>
</html>