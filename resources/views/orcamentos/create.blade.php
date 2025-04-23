@extends('layouts.app')

@section('title', 'Novo Orçamento')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Criar Novo Orçamento</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('orcamentos.store') }}" method="POST">
                @csrf
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="veiculo_id" class="form-label">Veículo</label>
                            <select class="form-select" id="veiculo_id" name="veiculo_id" required>
                                <option value="">Selecione um veículo</option>
                                @foreach($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}">
                                        {{ $veiculo->placa }} - {{ $veiculo->modelo }} ({{ $veiculo->cliente->nome }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descricao" class="form-label">Descrição do Serviço</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="validade" class="form-label">Validade</label>
                            <input type="date" class="form-control" id="validade" name="validade" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="valor_mao_de_obra" class="form-label">Mão de Obra (R$)</label>
                                <input type="number" step="0.01" class="form-control" 
                                       id="valor_mao_de_obra" name="valor_mao_de_obra" required>
                            </div>
                            <div class="col-md-6">
                                <label for="valor_total" class="form-label">Total (R$)</label>
                                <input type="number" step="0.01" class="form-control bg-light" 
                                       id="valor_total" name="valor_total" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="border p-3 rounded">
                            <label class="form-label">Itens do Orçamento</label>
                            <div id="itens-container">
                                <div class="item row mb-3 g-3">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" 
                                               name="itens[0][nome]" placeholder="Nome do item" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" 
                                               name="itens[0][quantidade]" placeholder="Qtd" min="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" step="0.01" class="form-control" 
                                               name="itens[0][valor_unitario]" placeholder="Valor unitário" min="0" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-remover-item w-100">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="btn-adicionar-item" class="btn btn-sm btn-success">
                                    <i class="fas fa-plus me-2"></i>Adicionar Item
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('orcamentos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Salvar Orçamento
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itensContainer = document.getElementById('itens-container');
    const btnAdicionar = document.getElementById('btn-adicionar-item');
    let contadorItens = 1;

    btnAdicionar.addEventListener('click', function() {
        const novoItem = `
            <div class="item row mb-3 g-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" 
                           name="itens[${contadorItens}][nome]" placeholder="Nome do item" required>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" 
                           name="itens[${contadorItens}][quantidade]" placeholder="Qtd" min="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" class="form-control" 
                           name="itens[${contadorItens}][valor_unitario]" placeholder="Valor unitário" min="0" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remover-item w-100">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        itensContainer.insertAdjacentHTML('beforeend', novoItem);
        contadorItens++;
    });

    itensContainer.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remover-item')) {
            e.target.closest('.item').remove();
            calcularTotal();
        }
    });

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

    itensContainer.addEventListener('input', calcularTotal);
    document.getElementById('valor_mao_de_obra').addEventListener('input', calcularTotal);
});
</script>
@endsection