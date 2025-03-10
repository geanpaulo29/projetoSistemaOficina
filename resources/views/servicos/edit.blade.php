<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço</title>
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
            <a class="navbar-brand" href="{{ route('home') }}">Home</a>
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
        <h1 class="mb-4">Editar Serviço</h1>

        <!-- Exibe erros de validação -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('servicos.update', $servico->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="veiculo_id" class="form-label">Placa do Veículo</label>
                <select class="form-control" id="veiculo_id" name="veiculo_id" required>
                    <option value="">Selecione a placa do veículo</option>
                    @foreach($veiculos as $veiculo)
                        <option value="{{ $veiculo->id }}" {{ $servico->veiculo_id == $veiculo->id ? 'selected' : '' }}>
                            {{ $veiculo->placa }} - {{ $veiculo->modelo }} ({{ $veiculo->cliente->nome }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $servico->descricao }}</textarea>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" class="form-control" id="valor" name="valor" step="0.01" value="{{ $servico->valor }}" required>
            </div>
            <div class="mb-3">
                <label for="data_servico" class="form-label">Data do Serviço</label>
                <input type="date" class="form-control" id="data_servico" name="data_servico" value="{{ $servico->data_servico }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>