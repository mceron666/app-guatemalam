<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login
     */
    public function showLoginForm()
    {
        // Si el usuario ya está autenticado, redirigir a la página principal
        if (Session::has('usuario')) {
            return redirect('/');
        }
        
        return view('auth.login');
    }

    /**
     * Maneja el proceso de login
     */
    public function login(Request $request)
    {
        $request->validate([
            'CORREO_O_PERFIL' => 'required|string',
            'CLAVE_PERFIL' => 'required|string',
        ]);

        try {
            // Consumir la API de login directamente en la URL especificada
            $response = Http::post('http://localhost:3000/login', [
                'CORREO_O_PERFIL' => $request->CORREO_O_PERFIL,
                'CLAVE_PERFIL' => $request->CLAVE_PERFIL,
            ]);

            $data = $response->json();

            // Si la respuesta no es exitosa
            if ($response->failed()) {
                return back()->withErrors(['auth' => $data['mensaje'] ?? 'Error de autenticación'])->withInput($request->except('CLAVE_PERFIL'));
            }

            // Verificar si hay datos de usuario en la respuesta
            if (!isset($data['usuario'])) {
                return back()->withErrors(['auth' => 'Respuesta de API inválida'])->withInput($request->except('CLAVE_PERFIL'));
            }

            // Verificar el rol del usuario
            $usuario = $data['usuario'];
            $rol = $usuario['ROL_PERSONA'];

            // Verificar si el rol es válido para acceder
            if (!in_array($rol, ['G', 'A', 'M', 'P'])) {
                return back()->withErrors(['auth' => 'No tienes permisos para acceder al sistema'])->withInput($request->except('CLAVE_PERFIL'));
            }

            // Guardar datos del usuario en la sesión
            Session::put('usuario', $usuario);
            Session::put('autenticado', true);
            if ($rol == 'M')
            {
                return redirect('maestro/');
            } 
            elseif ($rol == 'A')
            {
                return redirect('alumno/');                
            }
            elseif ($rol == 'G')
            {
                return redirect('/');                
            }            
            elseif ($rol == 'P')
            {
                return redirect('/modo');                
            }            
        } catch (\Exception $e) {
            return back()->withErrors(['auth' => 'Error al conectar con el servidor: ' . $e->getMessage()])->withInput($request->except('CLAVE_PERFIL'));
        }
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout()
    {
        Session::forget('usuario');
        Session::forget('autenticado');
        
        return redirect('/login');
    }
}