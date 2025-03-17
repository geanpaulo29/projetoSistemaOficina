@extends('layouts.app')

@section('title', 'Resultados da Busca')

@section('content')
    <div class="container">
        <h1 class="mb-4">Resultados da Busca</h1>

        <form action="{{ route('veiculos.find') }}" method="GET" class="mb-4">
            <div class="mb-3">
                <label for="search" class="form-label">Modelo, Placa ou Marca do Veículo</label>
                <input type="text" class="form-control" id="search" name="search" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        @if ($veiculos->isEmpty())
            <div class="alert alert-warning">Nenhum veículo encontrado.</div>
        @else
            <h2 class="mt-5 mb-4">Veículos Encontrados</h2>
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
@endsection