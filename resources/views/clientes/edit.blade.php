@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Editar Cliente</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
    </div>

    <x-card title="Informações do Cliente">
        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" name="nome" value="{{ old('nome', $cliente->nome) }}" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" 
                               id="cpf" name="cpf" value="{{ old('cpf', $cliente->cpf) }}" required>
                        @error('cpf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                               id="telefone" name="telefone" value="{{ old('telefone', $cliente->telefone) }}" required>
                        @error('telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                               id="cidade" name="cidade" value="{{ old('cidade', $cliente->cidade) }}" required>
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control @error('bairro') is-invalid @enderror" 
                               id="bairro" name="bairro" value="{{ old('bairro', $cliente->bairro) }}" required>
                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control @error('rua') is-invalid @enderror" 
                               id="rua" name="rua" value="{{ old('rua', $cliente->rua) }}" required>
                        @error('rua')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                               id="numero" name="numero" value="{{ old('numero', $cliente->numero) }}" required>
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
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