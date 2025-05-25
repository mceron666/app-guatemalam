<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Session::has('autenticado') || !Session::get('autenticado')) {
            return redirect('/login');
        }

        // Verificar si el rol es válido
        $usuario = Session::get('usuario');
        if (!isset($usuario['ROL_PERSONA']) || !in_array($usuario['ROL_PERSONA'], ['G', 'A', 'M', 'P'])) {
            Session::forget('usuario');
            Session::forget('autenticado');
            return redirect('/login')->withErrors(['auth' => 'No tienes permisos para acceder al sistema']);
        }

        return $next($request);
    }
}
