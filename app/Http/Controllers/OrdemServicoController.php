<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class OrdemServicoController extends Controller
{
    // Exibe a ordem de serviço
    public function show($id)
    {
        $servico = Servico::with('veiculo.cliente')->findOrFail($id);
        $configuracao = Configuracao::first(); // Busca as configurações da oficina

        return view('ordem_servico.show', compact('servico', 'configuracao'));
    }
}