@extends('layouts.app')

@section('title', 'Orçamentos Pendentes')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Orçamentos Pendentes</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('orcamentos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Novo Orçamento
            </a>
        </div>
    </div>

    <x-card title="Lista de Orçamentos">
        @if ($orcamentos->isEmpty())
            <div class="alert alert-info">
                Nenhum orçamento pendente encontrado.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Veículo</th>
                            <th>Valor Total</th>
                            <th>Validade</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orcamentos as $orcamento)
                            <tr>
                                <td>{{ $orcamento->cliente->nome }}</td>
                                <td>{{ $orcamento->veiculo->modelo }} ({{ $orcamento->veiculo->placa }})</td>
                                <td class="fw-bold text-success">R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($orcamento->validade)->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('orcamentos.pdf', $orcamento->id) }}" 
                                           class="btn btn-sm btn-info" title="Imprimir">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <form action="{{ route('orcamentos.approve', $orcamento->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Aprovar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('orcamentos.destroy', $orcamento->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Excluir este orçamento?')"
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
            
            <div class="d-flex justify-content-center mt-4">
                {{ $orcamentos->links() }}
            </div>
        @endif
    </x-card>
</div>
@endsection