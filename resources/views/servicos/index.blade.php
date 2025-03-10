<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Serviços</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .container {
            margin-top: 80px;
        }
        .sortable {
            cursor: pointer;
        }
        .sortable:hover {
            text-decoration: underline;
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
        <h1 class="mb-4">Lista de Serviços</h1>

        <!-- Feedback dos filtros ativos -->
        @if (request()->filled('search') || request()->filled('data_inicio') || request()->filled('valor_minimo'))
            <div class="mb-4">
                <h5>Filtros Ativos:</h5>
                @if (request()->filled('search'))
                    <div class="filter-active">
                        <strong>Termo de busca:</strong> {{ request('search') }}
                        <button onclick="removeFilter('search')">×</button>
                    </div>
                @endif
                @if (request()->filled('data_inicio') && request()->filled('data_fim'))
                    <div class="filter-active">
                        <strong>Período:</strong> {{ request('data_inicio') }} até {{ request('data_fim') }}
                        <button onclick="removeFilter('data_inicio')">×</button>
                    </div>
                @endif
                @if (request()->filled('valor_minimo'))
                    <div class="filter-active">
                        <strong>Valor mínimo:</strong> R$ {{ number_format(request('valor_minimo'), 2, ',', '.') }}
                        <button onclick="removeFilter('valor_minimo')">×</button>
                    </div>
                @endif
            </div>
        @endif

        <!-- Formulário de busca e filtros avançados -->
        <form action="{{ route('servicos.find') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <!-- Campo de busca -->
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Pesquisar por placa, nome do veículo ou nome do cliente..." value="{{ request('search') }}">
                </div>
                <!-- Filtro por data -->
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_inicio" placeholder="Data inicial" value="{{ request('data_inicio') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_fim" placeholder="Data final" value="{{ request('data_fim') }}">
                </div>
                <!-- Filtro por valor mínimo -->
                <div class="col-md-2">
                    <input type="number" class="form-control" name="valor_minimo" placeholder="Valor mínimo" value="{{ request('valor_minimo') }}">
                </div>
                <!-- Botão de busca -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de serviços -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="sortable" onclick="sortTable('data_servico')">Data</th>
                    <th>Veículo</th>
                    <th>Descrição</th>
                    <th>Cliente</th>
                    <th class="sortable" onclick="sortTable('valor')">Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicos as $servico)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($servico->data_servico)) }}</td>
                        <td>{{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</td>
                        <td>{{ $servico->descricao }}</td>
                        <td>{{ $servico->veiculo->cliente->nome }}</td>
                        <td>R$ {{ number_format($servico->valor, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('servicos.edit', $servico->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Links de paginação -->
        <div class="d-flex justify-content-center">
            {{ $servicos->links() }}
        </div>
    </div>

    <!-- Script para ordenação e remoção de filtros -->
    <script>
        // Ordenação
        function sortTable(column) {
            const url = new URL(window.location.href);
            const direction = url.searchParams.get('direcao') === 'asc' ? 'desc' : 'asc';
            url.searchParams.set('ordenar_por', column);
            url.searchParams.set('direcao', direction);
            window.location.href = url.toString();
        }

        // Remoção de filtros
        function removeFilter(filter) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filter);

            // Se o filtro for de data, remova ambos os campos (data_inicio e data_fim)
            if (filter === 'data_inicio') {
                url.searchParams.delete('data_fim');
            }

            window.location.href = url.toString();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>