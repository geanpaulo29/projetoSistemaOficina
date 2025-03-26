<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    // Define o nome da tabela manualmente
    protected $table = 'configuracoes';

    protected $fillable = [
        'nome_oficina',
        'logo_oficina',
        'cnpj',
        'cep',
        'cidade',
        'bairro',
        'rua',
        'numero',
        'telefone',
        'email',
    ];
}