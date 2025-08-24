<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AlumnoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si está autenticado
        if (!Session::has('autenticado') || !Session::get('autenticado')) {
            return redirect('/login');
        }

        // Verificar si es alumno (rol A)
        $usuario = Session::get('usuario');
        if (!$usuario || $usuario['ROL_PERSONA'] !== 'A') {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}