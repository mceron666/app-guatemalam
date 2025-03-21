<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('usuario')) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        return $next($request);
    }
}

