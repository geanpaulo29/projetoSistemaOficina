<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\ConfiguracaoController;

// Rotas para Clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
Route::get('/clientes/find', [ClienteController::class, 'find'])->name('clientes.find');
Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

// Rotas para Veículos
Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
Route::get('/veiculos/create', [VeiculoController::class, 'create'])->name('veiculos.create');
Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
Route::get('/veiculos/search', [VeiculoController::class, 'search'])->name('veiculos.search');
Route::get('/veiculos/find', [VeiculoController::class, 'find'])->name('veiculos.find');
Route::get('/veiculos/{id}/edit', [VeiculoController::class, 'edit'])->name('veiculos.edit');
Route::put('/veiculos/{id}', [VeiculoController::class, 'update'])->name('veiculos.update');
Route::delete('/veiculos/{id}', [VeiculoController::class, 'destroy'])->name('veiculos.destroy');

// Rotas para Serviços
Route::get('/servicos', [ServicoController::class, 'index'])->name('servicos.index');
Route::get('/servicos/create', [ServicoController::class, 'create'])->name('servicos.create');
Route::post('/servicos', [ServicoController::class, 'store'])->name('servicos.store');
Route::get('/servicos/search', [ServicoController::class, 'search'])->name('servicos.search');
Route::get('/servicos/find', [ServicoController::class, 'find'])->name('servicos.find');
Route::get('/servicos/{id}/edit', [ServicoController::class, 'edit'])->name('servicos.edit');
Route::put('/servicos/{id}', [ServicoController::class, 'update'])->name('servicos.update');
Route::delete('/servicos/{id}', [ServicoController::class, 'destroy'])->name('servicos.destroy');
Route::get('/servicos/{id}/detalhes', [ServicoController::class, 'detalhes'])->name('servicos.detalhes');
Route::get('/ordem-servico/{id}', [ServicoController::class, 'gerarOrdemServico'])->name('ordem-servico.show');
Route::get('/ordem-servico/{id}/pdf', [OrdemServicoController::class, 'gerarPdf'])->name('ordem-servico.pdf');


// Rotas para Relatórios
Route::get('/relatorios/servicos', [RelatorioController::class, 'servicos'])->name('relatorios.servicos');
Route::get('/relatorios/clientes', [RelatorioController::class, 'clientes'])->name('relatorios.clientes');
Route::get('/relatorios/faturamento', [RelatorioController::class, 'faturamento'])->name('relatorios.faturamento');
Route::get('/relatorios/faturamento/detalhes/{ano}/{mes}', [RelatorioController::class, 'faturamentoDetalhes'])->name('relatorios.faturamento.detalhes');
Route::prefix('relatorios')->group(function() {
    // ... outras rotas de relatórios ...    
Route::get('/faturamento', [RelatorioController::class, 'faturamento'])->name('relatorios.faturamento');
Route::get('/faturamento/detalhes/{ano}/{mes}', [RelatorioController::class, 'faturamentoDetalhes'])
         ->name('relatorios.faturamento.detalhes');});

// Rotas para Configurações
Route::get('/configuracoes', [ConfiguracaoController::class, 'edit'])->name('configuracoes.edit');
Route::put('/configuracoes', [ConfiguracaoController::class, 'update'])->name('configuracoes.update');

// Rotas de Autenticação
Route::redirect('/', '/login');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');