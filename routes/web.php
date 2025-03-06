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


// Rotas para busca de clientes
Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
Route::get('/clientes/find', [ClienteController::class, 'find'])->name('clientes.find');

// Rotas para busca de veículos
Route::get('/veiculos/search', [VeiculoController::class, 'search'])->name('veiculos.search');
Route::get('/veiculos/find', [VeiculoController::class, 'find'])->name('veiculos.find');

// Rotas para serviços
Route::get('/servicos', [ServicoController::class, 'index'])->name('servicos.index');
Route::get('/servicos/create', [ServicoController::class, 'create'])->name('servicos.create');
Route::post('/servicos', [ServicoController::class, 'store'])->name('servicos.store');
Route::get('/servicos/{id}/edit', [ServicoController::class, 'edit'])->name('servicos.edit'); // Rota para edição
Route::put('/servicos/{id}', [ServicoController::class, 'update'])->name('servicos.update'); // Rota para atualização
Route::delete('/servicos/{id}', [ServicoController::class, 'destroy'])->name('servicos.destroy'); // Rota para exclusão

// Rotas para Veículos
// Rotas para veículos
Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
Route::get('/veiculos/create', [VeiculoController::class, 'create'])->name('veiculos.create');
Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
Route::get('/veiculos/search', [VeiculoController::class, 'search'])->name('veiculos.search');
Route::get('/veiculos/find', [VeiculoController::class, 'find'])->name('veiculos.find');
Route::get('/veiculos/{id}/edit', [VeiculoController::class, 'edit'])->name('veiculos.edit');
Route::put('/veiculos/{id}', [VeiculoController::class, 'update'])->name('veiculos.update');
Route::delete('/veiculos/{id}', [VeiculoController::class, 'destroy'])->name('veiculos.destroy');

// Rotas para Clientes
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
// web.php

Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

// Redireciona a rota raiz para a página de login
Route::redirect('/', '/login');

// Página inicial (após o login)
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rotas de Login e Registro (acessíveis apenas para usuários não autenticados)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// Rota de logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Rota de recuperação de senha
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');