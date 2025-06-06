<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'veiculo_id',
        'descricao',
        'valor_mao_de_obra',
        'itens', // Campo JSON
        'valor_total',
        'data_servico',
    ];
    
    
    // Acessor para calcular o total (opcional, se quiser calcular no backend)
    public function getValorTotalAttribute()
    {
        $totalItens = collect($this->itens)->sum(function ($item) {
            return $item['quantidade'] * $item['valor_unitario'];
        });
        return $totalItens + $this->valor_mao_de_obra;
    }

    public function getDataServicoFormatadaAttribute()
    {
    return $this->data_servico->format('d/m/Y');
    }

    // Define o cast para o campo data_servico
    // app/Models/Servico.php
    protected $casts = [
        'itens' => 'array', // Converte automaticamente JSON para array
        'data_servico' => 'date',
    ];

    // Relacionamento com Veículo
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    // Acessar o cliente através do veículo
    public function cliente()
    {
        return $this->veiculo ? $this->veiculo->cliente : null;
    }
}