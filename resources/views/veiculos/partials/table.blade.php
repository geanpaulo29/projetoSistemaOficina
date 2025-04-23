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
        <tbody>
            @foreach($veiculos as $veiculo)
                <tr>
                    <td>{{ $veiculo->modelo }}</td>
                    <td>{{ $veiculo->placa }}</td>
                    <td>{{ $veiculo->marca }}</td>
                    <td>{{ $veiculo->ano }}</td>
                    <td>{{ $veiculo->cor }}</td>
                    <td>{{ $veiculo->cliente->nome ?? 'Não informado' }}</td>
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