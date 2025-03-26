@extends('layouts.app')

@section('title', 'Lista de Serviços')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Serviços</h1>

    <!-- Filtros (mantenha os existentes) -->
    
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Veículo</th>
                    <th>Cliente</th>
                    <th>Descrição</th>
                    <th>Valor Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servicos as $servico)
                    <tr>
                        <td>{{ $servico->data_servico->format('d/m/Y') }}</td>
                        <td>{{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</td>
                        <td>{{ $servico->veiculo->cliente->nome }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" 
                                    onclick="window.location.href='{{ route('servicos.detalhes', $servico->id) }}'">
                                Ver Detalhes
                            </button>
                        </td>
                        <td>R$ {{ number_format($servico->valor_total, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('ordem-servico.pdf', $servico->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a href="{{ route('servicos.edit', $servico->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Excluir serviço?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    {{ $servicos->links() }}
</div>

    <script>
        function removeFilter(filter) {
            const url = new URL(window.location.href);
            url.searchParams.delete(filter);

            // Se o filtro for de data, remova ambos os campos (data_inicio e data_fim)
            if (filter === 'data_inicio') {
                url.searchParams.delete('data_fim');
            }

            window.location.href = url.toString();
        }
    </script>

    <style>
        .filter-active {
            display: flex;
            align-items: center;
            gap: 5px;
            background-color: #f8f9fa;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .filter-active button {
            padding: 0;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
@endsection