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
Route::get('/servicos/create', [ServicoController::class, 'create'])->name('servicos.create');
Route::post('/servicos', [ServicoController::class, 'store'])->name('servicos.store');
Route::get('/servicos', [ServicoController::class, 'index'])->name('servicos.index');

// Rotas para Veículos
Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
Route::get('/veiculos/create', [VeiculoController::class, 'create'])->name('veiculos.create');
Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
Route::get('/veiculos/search', [VeiculoController::class, 'search'])->name('veiculos.search');
Route::get('/veiculos/find', [VeiculoController::class, 'find'])->name('veiculos.find');

// Rotas para Clientes
Route::get('/clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');

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