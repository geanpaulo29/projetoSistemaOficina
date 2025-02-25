<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Retorna a view de registro
    }

    public function register(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users', // Verifica se o email é único
            'password' => 'required|string|min:8|confirmed', // Senha com confirmação
        ]);

        // Cria o usuário no banco de dados
        $user = User::create([
            'name' => $request->name, // Agora usamos o campo name
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Realiza o login automático após o registro
        Auth::login($user);

        // Redireciona para a página inicial
        return redirect()->route('home');
    }
}
