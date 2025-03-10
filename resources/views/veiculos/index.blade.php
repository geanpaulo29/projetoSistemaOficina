@extends('layouts.app')

@section('title', 'Lista de Veículos')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista de Veículos</h1>

        <!-- Link para a página de busca -->
        <a href="{{ route('veiculos.search') }}" class="btn btn-primary mb-4">Buscar Veículos</a>

        <!-- Tabela de veículos -->
        @if ($veiculos->isEmpty())
            <div class="alert alert-warning">Nenhum veículo encontrado.</div>
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

        <!-- Links de paginação -->
        <div class="d-flex justify-content-center mt-4">
            {{ $veiculos->links() }}
        </div>
    </div>
@endsection