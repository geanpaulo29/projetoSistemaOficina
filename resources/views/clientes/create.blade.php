@extends('layouts.app')

@section('title', 'Cadastrar Cliente')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Cadastrar Novo Cliente</h2>
        </div>
    </div>

    <x-card title="Informações do Cliente">
        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" required>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="rua" name="rua" required>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>
                </div>
                
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Cadastrar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection