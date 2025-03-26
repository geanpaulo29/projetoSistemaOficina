<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Configuracao;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdemServicoController extends Controller
{
    // Método existente para mostrar a ordem de serviço
    public function show($id)
    {
        $servico = Servico::with('veiculo.cliente')->findOrFail($id);
        $configuracao = Configuracao::first();
        return view('ordem_servico.show', compact('servico', 'configuracao'));
    }

    // Novo método para gerar PDF
    public function gerarPdf($id)
    {
        $servico = Servico::with('veiculo.cliente')->findOrFail($id);
        $configuracao = Configuracao::first();

        $pdf = Pdf::loadView('ordem_servico.pdf', compact('servico', 'configuracao'));

        // Define o nome do arquivo
        $filename = "ordem_servico_{$servico->id}.pdf";

        // Retorna o PDF para download
        return $pdf->download($filename);

        // Ou para visualizar no navegador:
        // return $pdf->stream($filename);
    }
}