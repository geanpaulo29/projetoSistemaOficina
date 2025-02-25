<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = ['veiculo_id', 'descricao', 'valor', 'data_servico'];

    // Relacionamento com Veículo
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }

    // Acessar o cliente através do veículo
    public function cliente()
    {
        return optional($this->veiculo)->clientes->first();
    }
}