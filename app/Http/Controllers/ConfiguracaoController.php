<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    // Exibe o formulário de configurações
    public function edit()
    {
        $configuracao = Configuracao::first(); // Busca a primeira configuração (ou cria uma nova)
        return view('configuracoes.edit', compact('configuracao'));
    }

    // Salva as configurações
    public function update(Request $request)
    {
        $request->validate([
            'nome_oficina' => 'required|string|max:255',
            'logo_oficina' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cnpj' => 'nullable|string|max:18',
            'cep' => 'nullable|string|max:9',
            'cidade' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'rua' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:10',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
        ]);
    
        $configuracao = Configuracao::firstOrNew();
        $configuracao->fill($request->except('logo_oficina'));
    
        if ($request->hasFile('logo_oficina')) {
            $caminho = $request->file('logo_oficina')->store('logos', 'public');
            $configuracao->logo_oficina = $caminho;
        }
    
        $configuracao->save();
    
        return redirect()->route('configuracoes.edit')->with('success', 'Configurações salvas com sucesso!');
    }
}