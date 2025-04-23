@extends('layouts.app')

@section('title', 'Lista de Clientes')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Clientes Cadastrados</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Cliente
            </a>
            <a href="{{ route('clientes.search') }}" class="btn btn-outline-primary">
                <i class="fas fa-search me-2"></i>Buscar
            </a>
        </div>
    </div>

    <x-card title="Lista de Clientes">
        @if ($clientes->isEmpty())
            <div class="alert alert-info">
                Nenhum cliente encontrado.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Cidade</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>
                                <td>
                                    <strong>{{ $cliente->nome }}</strong>
                                    <div class="text-muted small">{{ $cliente->bairro }}</div>
                                </td>
                                <td>{{ $cliente->cpf }}</td>
                                <td>{{ $cliente->telefone }}</td>
                                <td>{{ $cliente->cidade }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" 
                                           class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este cliente?')"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $clientes->links() }}
            </div>
        @endif
    </x-card>
</div>
@endsection