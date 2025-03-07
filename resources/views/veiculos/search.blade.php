<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Veículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container {
            margin-top: 80px;
        }
        .filter-active {
            background-color: #e9ecef;
            border-radius: 5px;
            padding: 5px 10px;
            margin: 5px 0;
            display: inline-flex;
            align-items: center;
        }
        .filter-active button {
            margin-left: 10px;
            border: none;
            background: none;
            color: #dc3545;
            cursor: pointer;
        }
        .filter-active button:hover {
            color: #a71d2a;
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
        <h1 class="mb-4">Buscar Veículo</h1>

        <!-- Feedback dos filtros ativos -->
        @if (request()->filled('search') || request()->filled('modelo') || request()->filled('placa') || request()->filled('marca') || request()->filled('cor') || request()->filled('ano') || request()->filled('cliente_id'))
            <div class="mb-4">
                <h5>Filtros Ativos:</h5>
                @if (request()->filled('search'))
                    <div class="filter-active">
                        <strong>Termo de busca:</strong> {{ request('search') }}
                        <button onclick="removeFilter('search')">×</button>
                    </div>
                @endif
                @if (request()->filled('modelo'))
                    <div class="filter-active">
                        <strong>Modelo:</strong> {{ request('modelo') }}
                        <button onclick="removeFilter('modelo')">×</button>
                    </div>
                @endif
                @if (request()->filled('placa'))
                    <div class="filter-active">
                        <strong>Placa:</strong> {{ request('placa') }}
                        <button onclick="removeFilter('placa')">×</button>
                    </div>
                @endif
                @if (request()->filled('marca'))
                    <div class="filter-active">
                        <strong>Marca:</strong> {{ request('marca') }}
                        <button onclick="removeFilter('marca')">×</button>
                    </div>
                @endif
                @if (request()->filled('cor'))
                    <div class="filter-active">
                        <strong>Cor:</strong> {{ request('cor') }}
                        <button onclick="removeFilter('cor')">×</button>
                    </div>
                @endif
                @if (request()->filled('ano'))
                    <div class="filter-active">
                        <strong>Ano:</strong> {{ request('ano') }}
                        <button onclick="removeFilter('ano')">×</button>
                    </div>
                @endif
                @if (request()->filled('cliente_id'))
                    <div class="filter-active">
                        <strong>Cliente:</strong> {{ $clienteSelecionado->nome ?? 'Cliente não encontrado' }}
                        <button onclick="removeFilter('cliente_id')">×</button>
                    </div>
                @endif
            </div>
        @endif

        <!-- Formulário de busca e filtros avançados -->
        <form action="{{ route('veiculos.find') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <!-- Campo de busca geral -->
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Pesquisar por modelo, placa ou marca..." value="{{ request('search') }}">
                </div>
                <!-- Filtro por modelo -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="modelo" placeholder="Modelo" value="{{ request('modelo') }}">
                </div>
                <!-- Filtro por placa -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="placa" placeholder="Placa" value="{{ request('placa') }}">
                </div>
                <!-- Filtro por marca -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="marca" placeholder="Marca" value="{{ request('marca') }}">
                </div>
                <!-- Filtro por cor -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="cor" placeholder="Cor" value="{{ request('cor') }}">
                </div>
                <!-- Filtro por ano -->
                <div class="col-md-2">
                    <input type="number" class="form-control" name="ano" placeholder="Ano" value="{{ request('ano') }}">
                </div>
                <!-- Filtro por cliente -->
                <!-- Filtro por cliente -->
                <div class="col-md-3">
                    <select class="form-control" name="cliente_id">
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Botão de busca -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Lista de veículos encontrados -->
        @if ($veiculos->isEmpty())
            <div class="alert alert-warning mt-4">Nenhum veículo encontrado.</div>
        @else
            <h2 class="mt-5 mb-4">Resultados da Busca</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Cor</th>
                        <th>Ano</th>
                        <th>Dono</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($veiculos as $veiculo)
                        <tr>
                            <td>{{ $veiculo->modelo }}</td>
                            <td>{{ $veiculo->placa }}</td>
                            <td>{{ $veiculo->marca }}</td>
                            <td>{{ $veiculo->cor }}</td>
                            <td>{{ $veiculo->ano }}</td>
                            <td>{{ optional($veiculo->cliente)->nome ?? 'Cliente não encontrado' }}</td>
                            <td>
                                <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este veículo?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Script para remoção de filtros -->
    <script>
        function removeFilter(filter) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filter);
            window.location.href = url.toString();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>