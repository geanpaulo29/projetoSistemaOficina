@extends('layouts.app')

@section('title', 'Editar Serviço')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Editar Serviço</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('servicos.update', $servico->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="veiculo_id" class="form-label">Placa do Veículo</label>
                        <select class="form-control" id="veiculo_id" name="veiculo_id" required>
                            <option value="">Selecione a placa do veículo</option>
                            @foreach($veiculos as $veiculo)
                                <option value="{{ $veiculo->id }}" {{ $servico->veiculo_id == $veiculo->id ? 'selected' : '' }}>
                                    {{ $veiculo->placa }} - {{ $veiculo->modelo }} ({{ $veiculo->cliente->nome }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $servico->descricao }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="number" class="form-control" id="valor" name="valor" step="0.01" value="{{ $servico->valor }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_servico" class="form-label">Data do Serviço</label>
                        <input type="date" class="form-control" id="data_servico" name="data_servico" value="{{ $servico->data_servico }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </form>
            </div>
        </div>
    </div>
@endsection