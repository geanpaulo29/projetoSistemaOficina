@extends('layouts.app')

@section('title', 'Editar Veículo')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Editar Veículo</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
    </div>

    <x-card title="Dados do Veículo">
        <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control @error('modelo') is-invalid @enderror" 
                               id="modelo" name="modelo" value="{{ old('modelo', $veiculo->modelo) }}" required>
                        @error('modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control @error('placa') is-invalid @enderror" 
                               id="placa" name="placa" value="{{ old('placa', $veiculo->placa) }}" required>
                        @error('placa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control @error('marca') is-invalid @enderror" 
                               id="marca" name="marca" value="{{ old('marca', $veiculo->marca) }}" required>
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" class="form-control @error('cor') is-invalid @enderror" 
                               id="cor" name="cor" value="{{ old('cor', $veiculo->cor) }}" required>
                        @error('cor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="number" class="form-control @error('ano') is-invalid @enderror" 
                               id="ano" name="ano" value="{{ old('ano', $veiculo->ano) }}" 
                               min="1900" max="{{ date('Y') + 1 }}" required>
                        @error('ano')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <label for="cliente_id" class="form-label">Proprietário</label>
                        <select class="form-select @error('cliente_id') is-invalid @enderror" 
                                id="cliente_id" name="cliente_id" required>
                            <option value="">Selecione um cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" 
                                    {{ old('cliente_id', $veiculo->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nome }} - {{ $cliente->cpf }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-eraser me-2"></i> Limpar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Atualizar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection