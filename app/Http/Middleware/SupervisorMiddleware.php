<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SupervisorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si está autenticado
        if (!Session::has('autenticado') || !Session::get('autenticado')) {
            return redirect('/login');
        }

        // Verificar si es supervisor (rol P) - tiene acceso completo
        $usuario = Session::get('usuario');
        if (!$usuario || $usuario['ROL_PERSONA'] !== 'P') {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}