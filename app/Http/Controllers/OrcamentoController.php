<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Servico;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class OrcamentoController extends Controller
{

    public function gerarPdf($id)
    {
        $orcamento = Orcamento::with(['cliente', 'veiculo'])->findOrFail($id);
        
        $pdf = Pdf::loadView('orcamentos.pdf', compact('orcamento'));
        
        return $pdf->stream('orcamento-'.$orcamento->id.'.pdf');
    }
    public function create()
    {
        $veiculos = Veiculo::with('cliente')->get();
        return view('orcamentos.create', compact('veiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'descricao' => 'required|string',
            'valor_mao_de_obra' => 'required|numeric|min:0',
            'itens' => 'required|array',
            'itens.*.nome' => 'required|string',
            'itens.*.quantidade' => 'required|numeric|min:1',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'validade' => 'required|date'
        ]);

        $itens = collect($request->itens)->map(function ($item) {
            return [
                'nome' => $item['nome'],
                'quantidade' => $item['quantidade'],
                'valor_unitario' => $item['valor_unitario'],
                'valor_total' => $item['quantidade'] * $item['valor_unitario']
            ];
        });

        Orcamento::create([
            'cliente_id' => Veiculo::find($request->veiculo_id)->cliente_id,
            'veiculo_id' => $request->veiculo_id,
            'descricao' => $request->descricao,
            'valor_mao_de_obra' => $request->valor_mao_de_obra,
            'itens' => $itens,
            'valor_total' => $request->valor_total,
            'validade' => $request->validade
        ]);

        return redirect()->route('orcamentos.index')->with('success', 'Orçamento criado com sucesso!');
    }

    public function index()
    {
        $orcamentos = Orcamento::where('aprovado', false)
            ->with(['cliente', 'veiculo'])
            ->orderBy('validade')
            ->paginate(10);

        return view('orcamentos.index', compact('orcamentos'));
    }

    public function approve($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        
        $servico = Servico::create([
            'veiculo_id' => $orcamento->veiculo_id,
            'descricao' => $orcamento->descricao,
            'valor_mao_de_obra' => $orcamento->valor_mao_de_obra,
            'itens' => $orcamento->itens,
            'valor_total' => $orcamento->valor_total,
            'data_servico' => now(),
        ]);

        $orcamento->update([
            'aprovado' => true,
            'aprovado_em' => now(),
            'aprovado_por' => auth()->id()
        ]);

        return redirect()->route('servicos.index')->with('success', 'Orçamento aprovado e serviço criado!');
    }

    public function destroy($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->delete();
        return redirect()->back()->with('success', 'Orçamento excluído!');
    }
}