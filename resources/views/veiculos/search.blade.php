@extends('layouts.app')

@section('title', 'Buscar Veículos')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Busca de Veículos</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Voltar
            </a>
        </div>
    </div>

    <x-card title="Filtros de Busca">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" 
                       placeholder="Modelo, placa ou marca">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="placaInput" 
                       placeholder="Placa">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="modeloInput" 
                       placeholder="Modelo">
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" id="corInput" 
                       placeholder="Cor">
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" id="anoInput" 
                       placeholder="Ano">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="clienteSelect">
                    <option value="">Todos os proprietários</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
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
                            <th>Modelo</th>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Ano</th>
                            <th>Cor</th>
                            <th>Proprietário</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody id="resultsBody">
                        @foreach($veiculos as $veiculo)
                            <tr data-veiculo='@json($veiculo)' 
                                data-cliente="{{ optional($veiculo->cliente)->nome ?? '' }}">
                                <td>{{ $veiculo->modelo }}</td>
                                <td>{{ $veiculo->placa }}</td>
                                <td>{{ $veiculo->marca }}</td>
                                <td>{{ $veiculo->ano }}</td>
                                <td>{{ $veiculo->cor }}</td>
                                <td>{{ optional($veiculo->cliente)->nome ?? 'Não informado' }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('veiculos.edit', $veiculo->id) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Tem certeza que deseja excluir este veículo?')">
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
const allVeiculos = Array.from(document.querySelectorAll('#resultsBody tr')).map(row => ({
    element: row,
    modelo: row.cells[0].textContent,
    placa: row.cells[1].textContent,
    marca: row.cells[2].textContent,
    ano: row.cells[3].textContent,
    cor: row.cells[4].textContent,
    cliente: row.dataset.cliente,
    clienteId: row.dataset.clienteId
}));

function applyFilters() {
    const filters = {
        search: document.getElementById('searchInput').value.toLowerCase(),
        placa: document.getElementById('placaInput').value.toLowerCase(),
        modelo: document.getElementById('modeloInput').value.toLowerCase(),
        cor: document.getElementById('corInput').value.toLowerCase(),
        ano: document.getElementById('anoInput').value,
        clienteId: document.getElementById('clienteSelect').value
    };

    allVeiculos.forEach(veiculo => {
        const matches = (
            (veiculo.modelo.toLowerCase().includes(filters.search) ||
             veiculo.placa.toLowerCase().includes(filters.search) ||
             veiculo.marca.toLowerCase().includes(filters.search)) &&
            veiculo.placa.toLowerCase().includes(filters.placa) &&
            veiculo.modelo.toLowerCase().includes(filters.modelo) &&
            veiculo.cor.toLowerCase().includes(filters.cor) &&
            (filters.ano === '' || veiculo.ano === filters.ano) &&
            (filters.clienteId === '' || veiculo.clienteId === filters.clienteId)
        );

        veiculo.element.style.display = matches ? '' : 'none';
    });

    updateActiveFilters(filters);
}

function updateActiveFilters(filters) {
    const activeFiltersDiv = document.getElementById('activeFilters');
    let filtersHtml = '<h6>Filtros Ativos:</h6><div class="d-flex flex-wrap gap-2">';
    
    Object.entries(filters).forEach(([key, value]) => {
        if(value) {
            const filterName = {
                search: 'Termo',
                placa: 'Placa',
                modelo: 'Modelo',
                cor: 'Cor',
                ano: 'Ano',
                clienteId: 'Proprietário'
            }[key];

            const filterValue = key === 'clienteId' 
                ? document.getElementById('clienteSelect').options[document.getElementById('clienteSelect').selectedIndex].text
                : value;

            filtersHtml += `
                <div class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">
                    <strong>${filterName}:</strong> ${filterValue}
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
    switch(filterKey) {
        case 'search': document.getElementById('searchInput').value = ''; break;
        case 'placa': document.getElementById('placaInput').value = ''; break;
        case 'modelo': document.getElementById('modeloInput').value = ''; break;
        case 'cor': document.getElementById('corInput').value = ''; break;
        case 'ano': document.getElementById('anoInput').value = ''; break;
        case 'clienteId': document.getElementById('clienteSelect').value = ''; break;
    }
    applyFilters();
}

// Inicialização
document.querySelectorAll('input, select').forEach(element => {
    element.addEventListener('keyup', applyFilters);
    element.addEventListener('change', applyFilters);
});
</script>
@endpush
@endsection