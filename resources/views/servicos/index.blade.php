@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Lista de Serviços') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
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
                            <a href="{{ route('ordem-servico.show', $servico->id) }}" class="btn btn-sm btn-info">Gerar Ordem</a>
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
@endsection <!-- Fim da seção de conteúdo -->