@extends('layouts.app')

@section('title', 'Configurações da Oficina')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Configurações da Oficina</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
    </div>

    <x-card title="Dados da Oficina">
        <form action="{{ route('configuracoes.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <!-- Coluna Esquerda -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome_oficina" class="form-label">Nome da Oficina</label>
                        <input type="text" class="form-control @error('nome_oficina') is-invalid @enderror" 
                               id="nome_oficina" name="nome_oficina" 
                               value="{{ old('nome_oficina', $configuracao->nome_oficina ?? '') }}" required>
                        @error('nome_oficina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control @error('cnpj') is-invalid @enderror" 
                               id="cnpj" name="cnpj" 
                               value="{{ old('cnpj', $configuracao->cnpj ?? '') }}">
                        @error('cnpj')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control @error('cep') is-invalid @enderror" 
                               id="cep" name="cep" 
                               value="{{ old('cep', $configuracao->cep ?? '') }}">
                        @error('cep')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control @error('telefone') is-invalid @enderror" 
                               id="telefone" name="telefone" 
                               value="{{ old('telefone', $configuracao->telefone ?? '') }}">
                        @error('telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Coluna Direita -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control @error('cidade') is-invalid @enderror" 
                               id="cidade" name="cidade" 
                               value="{{ old('cidade', $configuracao->cidade ?? '') }}">
                        @error('cidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control @error('bairro') is-invalid @enderror" 
                               id="bairro" name="bairro" 
                               value="{{ old('bairro', $configuracao->bairro ?? '') }}">
                        @error('bairro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control @error('rua') is-invalid @enderror" 
                               id="rua" name="rua" 
                               value="{{ old('rua', $configuracao->rua ?? '') }}">
                        @error('rua')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                               id="numero" name="numero" 
                               value="{{ old('numero', $configuracao->numero ?? '') }}">
                        @error('numero')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Linha Inferior -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" 
                               value="{{ old('email', $configuracao->email ?? '') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo_oficina" class="form-label">Logo da Oficina</label>
                        <input type="file" class="form-control @error('logo_oficina') is-invalid @enderror" 
                               id="logo_oficina" name="logo_oficina" 
                               onchange="previewImage(event)">
                        @error('logo_oficina')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if ($configuracao->logo_oficina ?? false)
                            <img id="preview" src="{{ asset('storage/' . $configuracao->logo_oficina) }}" 
                                 alt="Logo da Oficina" class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                            <img id="preview" src="#" alt="Preview do Logo" 
                                 class="img-thumbnail mt-2" style="max-width: 200px; display: none;">
                        @endif
                    </div>
                </div>

                <!-- Botões -->
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-eraser me-2"></i> Limpar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Salvar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-card>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection