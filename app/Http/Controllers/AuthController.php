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
        // Si el usuario ya está autenticado, redirigir a la página principal según su rol
        if (Session::has('usuario')) {
            $rol = Session::get('usuario')['ROL_PERSONA'];
                        
            switch ($rol) {
                case 'M': // Maestro
                    return redirect('maestro/');
                case 'A': // Alumno
                    return redirect('alumno/');
                case 'G': // Administrador
                    return redirect('/');
                case 'P': // Supervisor (permisos de maestro y admin)
                    return redirect('/modo');
                default:
                    return redirect('/');
            }
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

            // Verificar si debe cambiar contraseña o no tiene clave
            if ($usuario['DEBE_CAMBIAR_PASSWORD'] === 'Y' || $usuario['TIENE_CLAVE'] === 'N') {
                // Guardar temporalmente los datos del usuario para el cambio de contraseña
                Session::put('usuario_temp', $usuario);
                return redirect('/cambiar-password');
            }

            // Guardar datos del usuario en la sesión
            Session::put('usuario', $usuario);
            Session::put('autenticado', true);
                        
            // Redirigir según el rol
            switch ($rol) {
                case 'M': // Maestro
                    return redirect('maestro/');
                case 'A': // Alumno
                    return redirect('alumno/');
                case 'G': // Administrador
                    return redirect('/');
                case 'P': // Supervisor (permisos de maestro y admin)
                    return redirect('/modo');
                default:
                    return redirect('/');
            }

        } catch (\Exception $e) {
            return back()->withErrors(['auth' => 'Error al conectar con el servidor: ' . $e->getMessage()])->withInput($request->except('CLAVE_PERFIL'));
        }
    }

    /**
     * Muestra el formulario para cambiar contraseña
     */
    public function showChangePasswordForm()
    {
        // Verificar que hay un usuario temporal en sesión
        if (!Session::has('usuario_temp')) {
            return redirect('/login')->withErrors(['auth' => 'Sesión expirada. Por favor, inicia sesión nuevamente.']);
        }

        $usuario = Session::get('usuario_temp');
        return view('auth.change-password', compact('usuario'));
    }

    /**
     * Procesa el cambio de contraseña
     */
    public function changePassword(Request $request)
    {
        // Verificar que hay un usuario temporal en sesión
        if (!Session::has('usuario_temp')) {
            return redirect('/login')->withErrors(['auth' => 'Sesión expirada. Por favor, inicia sesión nuevamente.']);
        }

        $request->validate([
            'nueva_clave' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
                'confirmed'
            ],
            'nueva_clave_confirmation' => 'required|string'
        ], [
            'nueva_clave.required' => 'La nueva contraseña es obligatoria.',
            'nueva_clave.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'nueva_clave.regex' => 'La contraseña debe contener al menos: una letra minúscula, una mayúscula, un número y un carácter especial.',
            'nueva_clave.confirmed' => 'Las contraseñas no coinciden.',
            'nueva_clave_confirmation.required' => 'Debes confirmar la nueva contraseña.'
        ]);

        try {
            $usuario = Session::get('usuario_temp');

            // Llamar a la API para crear/cambiar la clave
            $response = Http::post('http://localhost:3000/login/crear-clave', [
                'ID_PERSONA' => $usuario['ID_PERSONA'],
                'NUEVA_CLAVE' => $request->nueva_clave,
            ]);

            $data = $response->json();

            // Si la respuesta no es exitosa
            if ($response->failed()) {
                return back()->withErrors(['password' => $data['mensaje'] ?? 'Error al cambiar la contraseña']);
            }

            // Limpiar la sesión temporal
            Session::forget('usuario_temp');

            // Redirigir al login con mensaje de éxito
            return redirect('/login')->with('success', 'Contraseña cambiada exitosamente. Ahora puedes iniciar sesión con tu nueva contraseña.');

        } catch (\Exception $e) {
            return back()->withErrors(['password' => 'Error al conectar con el servidor: ' . $e->getMessage()]);
        }
    }

    /**
     * Cierra la sesión del usuario
     */
    public function logout()
    {
        Session::forget('usuario');
        Session::forget('autenticado');
        Session::forget('usuario_temp'); // Limpiar también la sesión temporal
                
        return redirect('/login');
    }
}
