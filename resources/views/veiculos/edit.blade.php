<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Veículo</title>
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
        <h1 class="mb-4">Editar Veículo</h1>

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

        <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $veiculo->modelo }}" required>
            </div>
            <div class="mb-3">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" value="{{ $veiculo->placa }}" required>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" value="{{ $veiculo->marca }}" required>
            </div>
            <div class="mb-3">
                <label for="cor" class="form-label">Cor</label>
                <input type="text" class="form-control" id="cor" name="cor" value="{{ $veiculo->cor }}" required>
            </div>
            <div class="mb-3">
                <label for="ano" class="form-label">Ano</label>
                <input type="number" class="form-control" id="ano" name="ano" value="{{ $veiculo->ano }}" required>
            </div>
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente</label>
                <select class="form-control" id="cliente_id" name="cliente_id" required>
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $veiculo->cliente_id == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>