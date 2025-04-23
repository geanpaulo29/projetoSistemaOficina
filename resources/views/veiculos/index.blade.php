@extends('layouts.app')

@section('title', 'Lista de Veículos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Veículos Cadastrados</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('veiculos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Veículo
            </a>
            <a href="{{ route('veiculos.search') }}" class="btn btn-outline-primary">
                <i class="fas fa-search me-2"></i>Buscar
            </a>
        </div>
    </div>

    <x-card title="Listagem Completa">
        @if ($veiculos->isEmpty())
            <div class="alert alert-info">
                Nenhum veículo cadastrado.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Modelo</th>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Proprietário</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($veiculos as $veiculo)
                            <tr>
                                <td>
                                    <strong>{{ $veiculo->modelo }}</strong>
                                    <div class="text-muted small">{{ $veiculo->ano }}</div>
                                </td>
                                <td>{{ $veiculo->placa }}</td>
                                <td>{{ $veiculo->marca }}</td>
                                <td>{{ $veiculo->cliente->nome ?? 'Não informado' }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('veiculos.edit', $veiculo->id) }}" 
                                           class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este veículo?')"
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
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Mostrando {{ $veiculos->firstItem() }} a {{ $veiculos->lastItem() }} de {{ $veiculos->total() }} registros
                </div>
                <div>
                    {{ $veiculos->links() }}
                </div>
            </div>
        @endif
    </x-card>
</div>
@endsection