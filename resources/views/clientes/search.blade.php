@extends('layouts.app')

@section('title', 'Buscar Clientes')

@section('content')
    <div class="container">
        <h1 class="mb-4">Buscar Clientes</h1>

        <!-- Filtros aplicados -->
        @if (request()->filled('search') || request()->filled('cidade') || request()->filled('bairro') || request()->filled('rua') || request()->filled('numero'))
            <div class="mb-4">
                <h5>Filtros Ativos:</h5>
                <div class="d-flex flex-wrap gap-2">
                    @if (request()->filled('search'))
                        <div class="filter-active">
                            <strong>Termo de busca:</strong> {{ request('search') }}
                            <button onclick="removeFilter('search')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('cidade'))
                        <div class="filter-active">
                            <strong>Cidade:</strong> {{ request('cidade') }}
                            <button onclick="removeFilter('cidade')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('bairro'))
                        <div class="filter-active">
                            <strong>Bairro:</strong> {{ request('bairro') }}
                            <button onclick="removeFilter('bairro')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('rua'))
                        <div class="filter-active">
                            <strong>Rua:</strong> {{ request('rua') }}
                            <button onclick="removeFilter('rua')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                    @if (request()->filled('numero'))
                        <div class="filter-active">
                            <strong>Número:</strong> {{ request('numero') }}
                            <button onclick="removeFilter('numero')" class="btn btn-sm btn-danger">×</button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Formulário de busca e filtros avançados -->
        <form action="{{ route('clientes.find') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <!-- Campo de busca geral -->
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Pesquisar por nome, CPF ou telefone..." value="{{ request('search') }}">
                </div>
                <!-- Filtro por cidade -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="cidade" placeholder="Cidade" value="{{ request('cidade') }}">
                </div>
                <!-- Filtro por bairro -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="bairro" placeholder="Bairro" value="{{ request('bairro') }}">
                </div>
                <!-- Filtro por rua -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="rua" placeholder="Rua" value="{{ request('rua') }}">
                </div>
                <!-- Filtro por número -->
                <div class="col-md-2">
                    <input type="text" class="form-control" name="numero" placeholder="Número" value="{{ request('numero') }}">
                </div>
                <!-- Botão de busca -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Resultados da busca -->
        @if ($clientes->isEmpty())
            <div class="alert alert-warning">Nenhum cliente encontrado.</div>
        @else
            <h2 class="mt-5 mb-4">Resultados da Busca</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th>Bairro</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->cpf }}</td>
                            <td>{{ $cliente->telefone }}</td>
                            <td>{{ $cliente->cidade }}</td>
                            <td>{{ $cliente->bairro }}</td>
                            <td>{{ $cliente->rua }}</td>
                            <td>{{ $cliente->numero }}</td>
                            <td>
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</button>
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

    <!-- Estilo para os filtros ativos -->
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