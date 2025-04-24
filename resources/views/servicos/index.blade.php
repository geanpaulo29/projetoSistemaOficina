@extends('layouts.app')

@section('title', 'Lista de Serviços')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Serviços Realizados</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('servicos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Serviço
            </a>
        </div>
    </div>

    <x-card title="Filtros">
        <form method="GET" action="{{ route('servicos.index') }}">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Buscar por descrição, cliente ou veículo" 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="placa" 
                           placeholder="Placa" value="{{ request('placa') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_inicio" 
                           value="{{ request('data_inicio') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="data_fim" 
                           value="{{ request('data_fim') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                </div>
            </div>
        </form>

        @if(request()->anyFilled(['search', 'placa', 'data_inicio', 'data_fim']))
            <div class="mb-3">
                <h5>Filtros Ativos:</h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(['search', 'placa', 'data_inicio', 'data_fim'] as $filtro)
                        @if(request()->filled($filtro))
                            <div class="badge bg-primary bg-opacity-10 text-primary py-2 px-3">
                                <strong>{{ ucfirst(str_replace('_', ' ', $filtro)) }}:</strong> 
                                {{ request($filtro) }}
                                <button onclick="removeFilter('{{ $filtro }}')" 
                                        class="btn btn-sm p-0 ms-2 text-primary">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </x-card>

    <x-card title="Resultados">
        @if($servicos->isEmpty())
            <div class="alert alert-info">
                Nenhum serviço encontrado com os filtros aplicados.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Veículo</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servicos as $servico)
                            <tr>
                                <td>{{ $servico->data_servico->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $servico->veiculo->modelo }}</strong>
                                    <div class="text-muted small">{{ $servico->veiculo->placa }}</div>
                                </td>
                                <td>{{ $servico->veiculo->cliente->nome }}</td>
                                <td class="fw-bold text-success">
                                    R$ {{ number_format($servico->valor_total, 2, ',', '.') }}
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('servicos.show', $servico->id) }}" 
                                           class="btn btn-sm btn-primary" title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('ordem-servico.pdf', $servico->id) }}" 
                                           class="btn btn-sm btn-info" title="Gerar PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        <a href="{{ route('servicos.edit', $servico->id) }}" 
                                           class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Excluir este serviço?')"
                                                    title="Excluir">
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
            
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Mostrando {{ $servicos->firstItem() }} a {{ $servicos->lastItem() }} de {{ $servicos->total() }} registros
                </div>
                <div>
                    {{ $servicos->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </x-card>
</div>

@push('scripts')
<script>
    function removeFilter(filter) {
        const url = new URL(window.location.href);
        url.searchParams.delete(filter);
        
        if (filter === 'data_inicio') {
            url.searchParams.delete('data_fim');
        }
        
        window.location.href = url.toString();
    }
</script>
@endpush
@endsection