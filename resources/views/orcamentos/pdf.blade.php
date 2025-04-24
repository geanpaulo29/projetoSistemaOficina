<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orçamento #{{ $orcamento->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin-bottom: 5px; }
        .header p { margin-top: 0; color: #666; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px; border: 1px solid #ddd; }
        .info-table .label { font-weight: bold; width: 30%; background-color: #f5f5f5; }
        .itens-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .itens-table th, .itens-table td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .itens-table th { background-color: #f5f5f5; }
        .total { text-align: right; font-weight: bold; font-size: 1.1em; }
        .footer { margin-top: 30px; text-align: center; font-size: 0.9em; color: #666; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Orçamento #{{ $orcamento->id }}</h1>
        <p>Emitido em: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Cliente:</td>
            <td>{{ $orcamento->cliente->nome }}</td>
        </tr>
        <tr>
            <td class="label">CPF/CNPJ:</td>
            <td>{{ $orcamento->cliente->cpf }}</td>
        </tr>
        <tr>
            <td class="label">Veículo:</td>
            <td>{{ $orcamento->veiculo->modelo }} ({{ $orcamento->veiculo->placa }})</td>
        </tr>
        <tr>
            <td class="label">Validade:</td>
            <td>{{ \Carbon\Carbon::parse($orcamento->validade)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <h3>Itens do Orçamento</h3>
    <table class="itens-table">
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Quantidade</th>
                <th class="text-right">Valor Unitário</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orcamento->itens as $item)
            <tr>
                <td>{{ $item['nome'] }}</td>
                <td class="text-right">{{ $item['quantidade'] }}</td>
                <td class="text-right">R$ {{ number_format($item['valor_unitario'], 2, ',', '.') }}</td>
                <td class="text-right">R$ {{ number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p>Mão de Obra: R$ {{ number_format($orcamento->valor_mao_de_obra, 2, ',', '.') }}</p>
        <p>Total do Orçamento: R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>{{ config('app.name') }} - {{ config('app.url') }}</p>
        <p>Telefone: {{ config('app.phone') }}</p>
    </div>
</body>
</html>