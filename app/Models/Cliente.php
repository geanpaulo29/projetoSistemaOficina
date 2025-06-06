<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'telefone',
        'cpf',
        'cidade',
        'bairro',
        'rua',
        'numero',
    ];

    // Relacionamento com Veículos
    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }
    public function servicos()
    {
        return $this->hasManyThrough(Servico::class, Veiculo::class);
    }
}