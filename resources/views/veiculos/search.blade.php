@extends('layouts.app')

@section('title', 'Buscar Veículos')

@section('content')
    <div class="container">
        <h1 class="mb-4">Buscar Veículos</h1>

        @if (request()->filled('search') || request()->filled('modelo') || request()->filled('placa') || request()->filled('marca') || request()->filled('cor') || request()->filled('ano') || request()->filled('cliente_id'))
            <div class="mb-4">
                <h5>Filtros Ativos:</h5>
                <div class="d-flex flex-wrap gap-2">
                    @if (request()->filled('search'))
                        <div class="filter-active">
                            <strong>Termo de busca:</strong> {{ request('search') }}
                            <button onclick="removeFilter('search')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('modelo'))
                        <div class="filter-active">
                            <strong>Modelo:</strong> {{ request('modelo') }}
                            <button onclick="removeFilter('modelo')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('placa'))
                        <div class="filter-active">
                            <strong>Placa:</strong> {{ request('placa') }}
                            <button onclick="removeFilter('placa')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('marca'))
                        <div class="filter-active">
                            <strong>Marca:</strong> {{ request('marca') }}
                            <button onclick="removeFilter('marca')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('cor'))
                        <div class="filter-active">
                            <strong>Cor:</strong> {{ request('cor') }}
                            <button onclick="removeFilter('cor')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('ano'))
                        <div class="filter-active">
                            <strong>Ano:</strong> {{ request('ano') }}
                            <button onclick="removeFilter('ano')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('cliente_id'))
                        <div class="filter-active">
                            <strong>Cliente:</strong> {{ optional($clientes->find(request('cliente_id')))->nome ?? 'Cliente não encontrado' }}
                            <button onclick="removeFilter('cliente_id')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <form action="{{ route('veiculos.find') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Pesquisar por modelo, placa ou marca..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="modelo" placeholder="Modelo" value="{{ request('modelo') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="placa" placeholder="Placa" value="{{ request('placa') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="marca" placeholder="Marca" value="{{ request('marca') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="cor" placeholder="Cor" value="{{ request('cor') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="ano" placeholder="Ano" value="{{ request('ano') }}">
                </div>
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
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        @if ($veiculos->isEmpty())
            <div class="alert alert-warning">Nenhum veículo encontrado.</div>
        @else
            <h2 class="mt-5 mb-4">Resultados da Busca</h2>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
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
                                    <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este veículo?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        function removeFilter(filter) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filter);
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