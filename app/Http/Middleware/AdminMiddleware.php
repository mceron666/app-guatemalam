<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si está autenticado
        if (!Session::has('autenticado') || !Session::get('autenticado')) {
            return redirect('/login');
        }

        // Verificar si es administrador (rol G) o tiene permisos de admin (rol P)
        $usuario = Session::get('usuario');
        if (!$usuario || !in_array($usuario['ROL_PERSONA'], ['G', 'P'])) {
            abort(403, 'No tienes permisos para acceder a esta sección de administración');
        }

        return $next($request);
    }
}