<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MaestroMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si está autenticado
        if (!Session::has('autenticado') || !Session::get('autenticado')) {
            return redirect('/login');
        }

        // Verificar si es maestro (rol M) o tiene permisos de maestro (rol P)
        $usuario = Session::get('usuario');
        if (!$usuario || !in_array($usuario['ROL_PERSONA'], ['M', 'P'])) {
            abort(403, 'No tienes permisos para acceder a esta sección de maestros');
        }

        return $next($request);
    }
}