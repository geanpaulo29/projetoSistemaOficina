<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ordem de Serviço #{{ $servico->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 150px; }
        .info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        .total { font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        @if($configuracao->logo_oficina)
            <img src="{{ storage_path('app/public/' . $configuracao->logo_oficina) }}" alt="Logo">
        @endif
        <h1>{{ $configuracao->nome_oficina ?? 'Oficina Mecânica' }}</h1>
        <p>
            <strong>CNPJ:</strong> {{ $configuracao->cnpj ?? '' }}<br>
            <strong>Endereço:</strong> 
            {{ $configuracao->rua ?? '' }}, {{ $configuracao->numero ?? '' }} - 
            {{ $configuracao->bairro ?? '' }}, {{ $configuracao->cidade ?? '' }} - 
            CEP: {{ $configuracao->cep ?? '' }}<br>
            <strong>Telefone:</strong> {{ $configuracao->telefone ?? '' }} | 
            <strong>E-mail:</strong> {{ $configuracao->email ?? '' }}
        </p>
        <h2>Ordem de Serviço #{{ $servico->id }}</h2>
    </div>

    <div class="info">
        <p><strong>Data:</strong> {{ $servico->data_servico->format('d/m/Y') }}</p>
        <p><strong>Cliente:</strong> {{ $servico->veiculo->cliente->nome }}</p>
        <p><strong>Veículo:</strong> {{ $servico->veiculo->modelo }} ({{ $servico->veiculo->placa }})</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $servico->descricao }}</td>
                <td>R$ {{ number_format($servico->valor, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Oficina {{ $configuracao->nome_oficina ?? '' }} - {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>