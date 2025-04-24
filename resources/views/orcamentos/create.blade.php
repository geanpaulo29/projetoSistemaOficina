@extends('layouts.app')

@section('title', 'Novo Orçamento')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Criar Novo Orçamento</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('orcamentos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
    </div>

    <x-card title="Dados do Orçamento">
        <form action="{{ route('orcamentos.store') }}" method="POST">
            @csrf
            
            <div class="row g-3">
                <!-- Coluna Esquerda -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="veiculo_id" class="form-label">Veículo</label>
                        <select class="form-select @error('veiculo_id') is-invalid @enderror" 
                                id="veiculo_id" name="veiculo_id" required>
                            <option value="">Selecione um veículo</option>
                            @foreach($veiculos as $veiculo)
                                <option value="{{ $veiculo->id }}" {{ old('veiculo_id') == $veiculo->id ? 'selected' : '' }}>
                                    {{ $veiculo->placa }} - {{ $veiculo->modelo }} ({{ $veiculo->cliente->nome }})
                                </option>
                            @endforeach
                        </select>
                        @error('veiculo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição do Serviço</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" name="descricao" rows="3" required>{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Coluna Direita -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="validade" class="form-label">Validade</label>
                        <input type="date" class="form-control @error('validade') is-invalid @enderror" 
                               id="validade" name="validade" value="{{ old('validade') }}" required>
                        @error('validade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valor_mao_de_obra" class="form-label">Mão de Obra (R$)</label>
                                <input type="number" step="0.01" class="form-control @error('valor_mao_de_obra') is-invalid @enderror" 
                                       id="valor_mao_de_obra" name="valor_mao_de_obra" value="{{ old('valor_mao_de_obra') }}" required>
                                @error('valor_mao_de_obra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="valor_total" class="form-label">Total (R$)</label>
                                <input type="number" step="0.01" class="form-control bg-light" 
                                       id="valor_total" name="valor_total" value="{{ old('valor_total') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Itens do Orçamento -->
                <div class="col-12">
                    <div class="border p-3 rounded">
                        <label class="form-label">Itens do Orçamento</label>
                        <div id="itens-container">
                            <div class="item row mb-3 g-3">
                                <div class="col-md-5">
                                    <input type="text" class="form-control @error('itens.0.nome') is-invalid @enderror" 
                                           name="itens[0][nome]" value="{{ old('itens.0.nome') }}" placeholder="Nome do item" required>
                                    @error('itens.0.nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control @error('itens.0.quantidade') is-invalid @enderror" 
                                           name="itens[0][quantidade]" value="{{ old('itens.0.quantidade') }}" placeholder="Qtd" min="1" required>
                                    @error('itens.0.quantidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <input type="number" step="0.01" class="form-control @error('itens.0.valor_unitario') is-invalid @enderror" 
                                           name="itens[0][valor_unitario]" value="{{ old('itens.0.valor_unitario') }}" placeholder="Valor unitário" min="0" required>
                                    @error('itens.0.valor_unitario')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                <i class="fas fa-plus me-2"></i> Adicionar Item
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="col-12 mt-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-eraser me-2"></i> Limpar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Salvar Orçamento
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-card>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itensContainer = document.getElementById('itens-container');
    const btnAdicionar = document.getElementById('btn-adicionar-item');
    let contadorItens = {{ count(old('itens', [['nome'=>'','quantidade'=>'','valor_unitario'=>'']])) }};

    // Adiciona novo item
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

    // Remove item
    itensContainer.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remover-item')) {
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

    // Calcula o total inicial
    calcularTotal();
});
</script>
@endsection