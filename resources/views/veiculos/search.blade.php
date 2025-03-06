<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Veículo</title>
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
    <div class="container">
        <h1 class="mb-4">Buscar Veículo</h1>

        <!-- Formulário de busca -->
        <form action="{{ route('veiculos.find') }}" method="GET">
            <div class="mb-3">
                <label for="search" class="form-label">Modelo, Placa ou Marca do Veículo</label>
                <input type="text" class="form-control" id="search" name="search" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <!-- Lista de todos os veículos cadastrados -->
        <h2 class="mt-5 mb-4">Veículos Cadastrados</h2>
        @if ($veiculos->isEmpty())
            <div class="alert alert-warning">Nenhum veículo cadastrado.</div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Cor</th>
                        <th>Ano</th>
                        <th>Dono</th>
                        <th>Ações</th> <!-- Coluna para os botões de ação -->
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
                                <!-- Botão de Editar -->
                                <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn btn-sm btn-warning">Editar</a>

                                <!-- Formulário de Exclusão -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>