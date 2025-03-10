@extends('layouts.app') <!-- Estende o layout principal -->

@section('title', 'Configurações da Oficina') <!-- Define o título da página -->

@section('content') <!-- Início da seção de conteúdo -->
    <div class="container mt-5">
        <h1>Configurações da Oficina</h1>

        <form action="{{ route('configuracoes.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nome_oficina" class="form-label">Nome da Oficina</label>
                <input type="text" class="form-control" id="nome_oficina" name="nome_oficina" value="{{ $configuracao->nome_oficina ?? '' }}" required>
            </div>

            <div class="mb-3">
                <label for="logo_oficina" class="form-label">Logo da Oficina</label>
                <input type="file" class="form-control" id="logo_oficina" name="logo_oficina">
                @if ($configuracao->logo_oficina ?? false)
                    <img src="{{ asset('storage/' . $configuracao->logo_oficina) }}" alt="Logo da Oficina" class="img-thumbnail mt-2" style="max-width: 200px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
@endsection <!-- Fim da seção de conteúdo -->