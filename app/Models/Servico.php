<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = ['veiculo_id', 'descricao', 'valor', 'data_servico'];

    public function getDataServicoFormatadaAttribute()
    {
    return $this->data_servico->format('d/m/Y');
    }

    // Define o cast para o campo data_servico
    protected $casts = [
        'data_servico' => 'date', // Converte automaticamente para Carbon
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