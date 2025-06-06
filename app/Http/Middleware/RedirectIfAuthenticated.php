<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Verifica se o usuário está autenticado
        if (Auth::guard($guard)->check()) {
            // Redireciona para a página home
            return redirect()->route('home');
        }

        return $next($request);
    }
}