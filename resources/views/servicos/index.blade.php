@extends('layouts.app')

@section('title', 'Lista de Serviços')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista de Serviços</h1>

        <!-- Filtros Ativos -->
        @if (request()->filled('search') || request()->filled('placa') || request()->filled('modelo') || request()->filled('cliente') || request()->filled('data_inicio') || request()->filled('valor_minimo'))
            <div class="mb-4">
                <h5>Filtros Ativos:</h5>
                <div class="d-flex flex-wrap gap-2">
                    @if (request()->filled('search'))
                        <div class="filter-active">
                            <strong>Busca global:</strong> {{ request('search') }}
                            <button onclick="removeFilter('search')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('placa'))
                        <div class="filter-active">
                            <strong>Placa:</strong> {{ request('placa') }}
                            <button onclick="removeFilter('placa')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('modelo'))
                        <div class="filter-active">
                            <strong>Modelo:</strong> {{ request('modelo') }}
                            <button onclick="removeFilter('modelo')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('cliente'))
                        <div class="filter-active">
                            <strong>Cliente:</strong> {{ request('cliente') }}
                            <button onclick="removeFilter('cliente')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('data_inicio') && request()->filled('data_fim'))
                        <div class="filter-active">
                            <strong>Período:</strong> {{ request('data_inicio') }} até {{ request('data_fim') }}
                            <button onclick="removeFilter('data_inicio')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('valor_minimo'))
                        <div class="filter-active">
                            <strong>Valor mínimo:</strong> R$ {{ number_format(request('valor_minimo'), 2, ',', '.') }}
                            <button onclick="removeFilter('valor_minimo')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Formulário de Busca e Filtros -->
        <form action="{{ route('servicos.index') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" placeholder="Busca global..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="placa" placeholder="Placa" value="{{ request('placa') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="modelo" placeholder="Modelo" value="{{ request('modelo') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="cliente" placeholder="Cliente" value="{{ request('cliente') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="data_inicio" placeholder="Data inicial" value="{{ request('data_inicio') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" name="data_fim" placeholder="Data final" value="{{ request('data_fim') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="valor_minimo" placeholder="Valor mínimo" value="{{ request('valor_minimo') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Tabela de Serviços -->
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Veículo</th>
                        <th>Descrição</th>
                        <th>Cliente</th>
                        <th>Valor</th>
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
                                <a href="{{ route('ordem-servico.show', $servico->id) }}" class="btn btn-sm btn-info" title="Gerar Ordem"><i class="fas fa-file-alt"></i></a>
                                <a href="{{ route('servicos.edit', $servico->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este serviço?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-4">
            {{ $servicos->links() }}
        </div>
    </div>

    <script>
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

    <style>
        .filter-active {
            display: flex;
            align-items: center;
            gap: 5px;
            background-color: #f8f9fa;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .filter-active button {
            padding: 0;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
@endsection