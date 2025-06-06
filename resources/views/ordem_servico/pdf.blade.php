<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ordem de Serviço #{{ $servico->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header img { max-width: 150px; }
        .info-cliente, .info-veiculo { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        @if($configuracao->logo_oficina)
            <img src="{{ storage_path('app/public/' . $configuracao->logo_oficina) }}" alt="Logo">
        @endif
        <h1>{{ $configuracao->nome_oficina ?? 'Oficina Mecânica' }}</h1>
        <p>
            <strong>CNPJ:</strong> {{ $configuracao->cnpj ?? 'Não informado' }} | 
            <strong>Telefone:</strong> {{ $configuracao->telefone ?? 'Não informado' }}<br>
            <strong>Endereço:</strong> {{ $configuracao->rua ?? '' }}, {{ $configuracao->numero ?? '' }} - 
            {{ $configuracao->bairro ?? '' }}, {{ $configuracao->cidade ?? '' }} - CEP: {{ $configuracao->cep ?? '' }}
        </p>
        <h2>ORDEM DE SERVIÇO #{{ $servico->id }}</h2>
    </div>

    <div class="info-cliente">
        <p><strong>Cliente:</strong> {{ $servico->veiculo->cliente->nome }}</p>
        <p><strong>CPF:</strong> {{ $servico->veiculo->cliente->cpf }}</p>
    </div>

    <div class="info-veiculo">
        <p><strong>Veículo:</strong> {{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</p>
        <p><strong>Data:</strong> {{ $servico->data_servico->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servico->itens ?? [] as $item)
                <tr>
                    <td>{{ $item['nome'] }}</td>
                    <td>{{ $item['quantidade'] }}</td>
                    <td>R$ {{ number_format($item['valor_unitario'], 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Mão de Obra</td>
                <td>R$ {{ number_format($servico->valor_mao_de_obra, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3">Total Geral</td>
                <td>R$ {{ number_format($servico->valor_total, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>{{ $configuracao->nome_oficina ?? 'Oficina Mecânica' }} - {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>