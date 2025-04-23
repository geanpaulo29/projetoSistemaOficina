<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'veiculo_id',
        'descricao',
        'valor_mao_de_obra',
        'itens',
        'valor_total',
        'validade',
        'aprovado',
        'aprovado_em',
        'aprovado_por'
    ];

    protected $casts = [
        'itens' => 'array',
        'validade' => 'date',
        'aprovado_em' => 'datetime'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    public function aprovador()
    {
        return $this->belongsTo(User::class, 'aprovado_por');
    }
}