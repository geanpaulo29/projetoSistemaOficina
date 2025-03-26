@extends('layouts.app')

@section('title', 'Editar Serviço')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Editar Serviço #{{ $servico->id }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('servicos.update', $servico->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="veiculo_id" class="form-label">Veículo</label>
                    <select class="form-control" id="veiculo_id" name="veiculo_id" required>
                        @foreach($veiculos as $veiculo)
                            <option value="{{ $veiculo->id }}" {{ $servico->veiculo_id == $veiculo->id ? 'selected' : '' }}>
                                {{ $veiculo->placa }} - {{ $veiculo->modelo }} ({{ $veiculo->cliente->nome }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição do Serviço</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $servico->descricao }}</textarea>
                </div>

                <!-- Itens do Serviço (Dinâmico) -->
                <div class="mb-3">
                    <label class="form-label">Peças Utilizadas</label>
                    <div id="itens-container">
                        @foreach($servico->itens as $index => $item)
                            <div class="item row mb-2 g-2">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="itens[{{ $index }}][nome]" 
                                           value="{{ $item['nome'] }}" placeholder="Nome da peça" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="itens[{{ $index }}][quantidade]" 
                                           value="{{ $item['quantidade'] }}" placeholder="Qtd" min="1" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" class="form-control" 
                                           name="itens[{{ $index }}][valor_unitario]" 
                                           value="{{ $item['valor_unitario'] }}" placeholder="Valor unitário" min="0" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-remover-item w-100">×</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="btn-adicionar-item" class="btn btn-sm btn-success mt-2">
                        <i class="fas fa-plus"></i> Adicionar Peça
                    </button>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="valor_mao_de_obra" class="form-label">Mão de Obra (R$)</label>
                        <input type="number" step="0.01" class="form-control" id="valor_mao_de_obra" 
                               name="valor_mao_de_obra" value="{{ $servico->valor_mao_de_obra }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="valor_total" class="form-label">Total (R$)</label>
                        <input type="number" step="0.01" class="form-control bg-light" id="valor_total" 
                               name="valor_total" value="{{ $servico->valor_total }}" readonly>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="data_servico" class="form-label">Data do Serviço</label>
                    <input type="date" class="form-control" id="data_servico" 
                           name="data_servico" value="{{ $servico->data_servico->format('Y-m-d') }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('servicos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Atualizar Serviço
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itensContainer = document.getElementById('itens-container');
        const btnAdicionar = document.getElementById('btn-adicionar-item');
        let contadorItens = {{ count($servico->itens) }};

        // Adiciona novo item
        btnAdicionar.addEventListener('click', function() {
            const novoItem = `
                <div class="item row mb-2 g-2">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="itens[${contadorItens}][nome]" placeholder="Nome da peça" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="itens[${contadorItens}][quantidade]" placeholder="Qtd" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" class="form-control" name="itens[${contadorItens}][valor_unitario]" placeholder="Valor unitário" min="0" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remover-item w-100">×</button>
                    </div>
                </div>
            `;
            itensContainer.insertAdjacentHTML('beforeend', novoItem);
            contadorItens++;
        });

        // Remove item
        itensContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-remover-item')) {
                e.target.closest('.item').remove();
                calcularTotal();
            }
        });

        // Calcula o total
        function calcularTotal() {
            let totalItens = 0;
            document.querySelectorAll('.item').forEach(item => {
                const qtd = parseFloat(item.querySelector('input[name$="[quantidade]"]').value) || 0;
                const valor = parseFloat(item.querySelector('input[name$="[valor_unitario]"]').value) || 0;
                totalItens += qtd * valor;
            });

            const maoDeObra = parseFloat(document.getElementById('valor_mao_de_obra').value) || 0;
            document.getElementById('valor_total').value = (totalItens + maoDeObra).toFixed(2);
        }

        // Atualiza o total quando os campos mudam
        itensContainer.addEventListener('input', calcularTotal);
        document.getElementById('valor_mao_de_obra').addEventListener('input', calcularTotal);
    });
</script>
@endsection