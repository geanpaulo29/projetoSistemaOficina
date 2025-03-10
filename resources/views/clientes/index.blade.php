@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista de Clientes</h1>

        <!-- Link para a página de busca -->
        <a href="{{ route('clientes.search') }}" class="btn btn-primary mb-4">Buscar Clientes</a>

        <!-- Tabela de clientes -->
        @if ($clientes->isEmpty())
            <div class="alert alert-warning">Nenhum cliente encontrado.</div>
        @else
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

        <!-- Links de paginação -->
        <div class="d-flex justify-content-center mt-4">
            {{ $clientes->links() }}
        </div>
    </div>
@endsection