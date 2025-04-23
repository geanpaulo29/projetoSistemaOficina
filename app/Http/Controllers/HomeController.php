<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Veiculo;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $servicosMensais = Servico::selectRaw('MONTH(data_servico) as mes, COUNT(*) as total')
            ->whereYear('data_servico', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                return [
                    'mes' => Carbon::createFromFormat('m', $item->mes)->format('F'),
                    'total' => $item->total
                ];
            });

        return view('home', [
            'totalClientes' => Cliente::count(),
            'totalVeiculos' => Veiculo::count(),
            'servicosEsteMes' => Servico::whereMonth('data_servico', now()->month)->count(),
            'faturamentoMes' => Servico::whereMonth('data_servico', now()->month)->sum('valor_total'),
            'ultimosServicos' => Servico::with(['veiculo.cliente'])
                ->orderBy('data_servico', 'desc')
                ->limit(5)
                ->get(),
            'servicosMensais' => $servicosMensais
        ]);
    }
}