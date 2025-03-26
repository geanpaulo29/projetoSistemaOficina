@extends('layouts.app')

@section('title', 'Configurações da Oficina')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Configurações da Oficina</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('configuracoes.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nome_oficina" class="form-label">Nome da Oficina</label>
                        <input type="text" class="form-control" id="nome_oficina" name="nome_oficina" value="{{ $configuracao->nome_oficina ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ $configuracao->cnpj ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" class="form-control" id="cep" name="cep" value="{{ $configuracao->cep ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="cidade" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $configuracao->cidade ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $configuracao->bairro ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="rua" class="form-label">Rua</label>
                        <input type="text" class="form-control" id="rua" name="rua" value="{{ $configuracao->rua ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" value="{{ $configuracao->numero ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $configuracao->telefone ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $configuracao->email ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="logo_oficina" class="form-label">Logo da Oficina</label>
                        <input type="file" class="form-control" id="logo_oficina" name="logo_oficina" onchange="previewImage(event)">
                        @if ($configuracao->logo_oficina ?? false)
                            <img id="preview" src="{{ asset('storage/' . $configuracao->logo_oficina) }}" alt="Logo da Oficina" class="img-thumbnail mt-2" style="max-width: 200px;">
                        @else
                            <img id="preview" src="#" alt="Preview do Logo" class="img-thumbnail mt-2" style="max-width: 200px; display: none;">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.style.display = 'block';
        }
    </script>
@endsection