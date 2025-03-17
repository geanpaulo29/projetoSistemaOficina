@extends('layouts.app')

@section('title', 'Editar Veículo')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Editar Veículo</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $veiculo->modelo }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" value="{{ $veiculo->placa }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" value="{{ $veiculo->marca }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" class="form-control" id="cor" name="cor" value="{{ $veiculo->cor }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="number" class="form-control" id="ano" name="ano" value="{{ $veiculo->ano }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select class="form-control" id="cliente_id" name="cliente_id" required>
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $veiculo->cliente_id == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
@endsection