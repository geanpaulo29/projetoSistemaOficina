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
            'logo_oficina' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Aceita apenas imagens
        ]);

        $configuracao = Configuracao::firstOrNew(); // Busca a primeira configuração ou cria uma nova
        $configuracao->nome_oficina = $request->input('nome_oficina');

        // Salva o logo da oficina (se fornecido)
        if ($request->hasFile('logo_oficina')) {
            $caminho = $request->file('logo_oficina')->store('logos', 'public'); // Salva a imagem na pasta "storage/app/public/logos"
            $configuracao->logo_oficina = $caminho;
        }

        $configuracao->save();

        return redirect()->route('configuracoes.edit')->with('success', 'Configurações salvas com sucesso!');
    }
}