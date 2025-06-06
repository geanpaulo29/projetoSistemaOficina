@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Resultados da Busca') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
    <div class="container">
        <h1 class="mb-4">Resultados da Busca</h1>

        <!-- Formulário de busca -->
        <form action="{{ route('clientes.find') }}" method="GET">
            <div class="mb-3">
                <label for="search" class="form-label">Nome ou CPF do Cliente</label>
                <input type="text" class="form-control" id="search" name="search" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <!-- Tabela de resultados -->
        @if ($clientes->isEmpty())
            <div class="alert alert-warning">Nenhum cliente encontrado.</div>
        @else
            <h2 class="mt-5 mb-4">Clientes Encontrados</h2>
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
@endsection <!-- Fim da seção de conteúdo -->