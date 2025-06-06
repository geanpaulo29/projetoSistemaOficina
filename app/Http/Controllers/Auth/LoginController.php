<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Retorna a view de login
    }

    public function login(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Tentando autenticar o usuário pelo email e senha
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Se autenticar, redireciona para a página home
            return redirect()->route('home');
        }

        // Se falhar, redireciona de volta com erro
        return Redirect::back()
            ->withErrors(['error' => 'Credenciais inválidas'])
            ->withInput($request->only('email', 'remember'));
    }

    // Método para logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}