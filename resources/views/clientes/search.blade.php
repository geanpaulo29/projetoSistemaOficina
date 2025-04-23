@extends('layouts.app')

@section('title', 'Buscar Clientes')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Busca de Clientes</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
    </div>

    <x-card title="Filtros de Busca">
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" class="form-control" id="nomeInput" 
                       placeholder="Nome">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="cpfInput" 
                       placeholder="CPF">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="telefoneInput" 
                       placeholder="Telefone">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="cidadeInput" 
                       placeholder="Cidade">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="bairroInput" 
                       placeholder="Bairro">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="ruaInput" 
                       placeholder="Rua">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="numeroInput" 
                       placeholder="Número">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" onclick="applyFilters()">
                    <i class="fas fa-search me-2"></i> Buscar
                </button>
            </div>
        </div>

        <div id="activeFilters" class="mt-4"></div>
    </x-card>

    <div id="resultsSection">
        <x-card title="Resultados" class="mt-4">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Cidade</th>
                            <th>Bairro</th>
                            <th>Rua</th>
                            <th>Número</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="resultsBody">
                        @foreach($clientes as $cliente)
                            <tr data-cliente='@json($cliente)'>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->cpf }}</td>
                                <td>{{ $cliente->telefone }}</td>
                                <td>{{ $cliente->cidade }}</td>
                                <td>{{ $cliente->bairro }}</td>
                                <td>{{ $cliente->rua }}</td>
                                <td>{{ $cliente->numero }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</div>

@push('scripts')
<script>
// Dados iniciais
const allClientes = Array.from(document.querySelectorAll('#resultsBody tr')).map(row => ({
    element: row,
    nome: row.cells[0].textContent.toLowerCase(),
    cpf: row.cells[1].textContent,
    telefone: row.cells[2].textContent,
    cidade: row.cells[3].textContent.toLowerCase(),
    bairro: row.cells[4].textContent.toLowerCase(),
    rua: row.cells[5].textContent.toLowerCase(),
    numero: row.cells[6].textContent
}));

function applyFilters() {
    const filters = {
        nome: document.getElementById('nomeInput').value.toLowerCase(),
        cpf: document.getElementById('cpfInput').value,
        telefone: document.getElementById('telefoneInput').value,
        cidade: document.getElementById('cidadeInput').value.toLowerCase(),
        bairro: document.getElementById('bairroInput').value.toLowerCase(),
        rua: document.getElementById('ruaInput').value.toLowerCase(),
        numero: document.getElementById('numeroInput').value
    };

    allClientes.forEach(cliente => {
        const matches = (
            cliente.nome.includes(filters.nome) &&
            cliente.cpf.includes(filters.cpf) &&
            cliente.telefone.includes(filters.telefone) &&
            cliente.cidade.includes(filters.cidade) &&
            cliente.bairro.includes(filters.bairro) &&
            cliente.rua.includes(filters.rua) &&
            cliente.numero.includes(filters.numero)
        );

        cliente.element.style.display = matches ? '' : 'none';
    });

    updateActiveFilters(filters);
}

function updateActiveFilters(filters) {
    const activeFiltersDiv = document.getElementById('activeFilters');
    let filtersHtml = '<h6>Filtros Ativos:</h6><div class="d-flex flex-wrap gap-2">';
    
    Object.entries(filters).forEach(([key, value]) => {
        if(value) {
            const filterName = {
                nome: 'Nome',
                cpf: 'CPF',
                telefone: 'Telefone',
                cidade: 'Cidade',
                bairro: 'Bairro',
                rua: 'Rua',
                numero: 'Número'
            }[key];

            filtersHtml += `
                <div class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">
                    <strong>${filterName}:</strong> ${value}
                    <button onclick="removeFilter('${key}')" class="btn btn-sm p-0 ms-2 text-primary">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        }
    });

    filtersHtml += '</div>';
    activeFiltersDiv.innerHTML = filtersHtml;
}

function removeFilter(filterKey) {
    document.getElementById(filterKey + 'Input').value = '';
    applyFilters();
}

// Inicialização
document.querySelectorAll('input').forEach(element => {
    element.addEventListener('keyup', applyFilters);
});
</script>
@endpush
@endsection