<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $apiUrl = 'https://127.0.0.1:7120/api/Usuarios/Login';

    public function login(Request $request)
    {
        // Validar entrada
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string|min:4',
        ]);
    
        // Obtener credenciales del request
        $credentials = [
            'correo' => $request->input('correo'),
            'password' => $request->input('password'),
        ];
    
        try {
            // Realizar la solicitud HTTP a la API
            $response = Http::withoutVerifying()->post($this->apiUrl, $credentials);
    
            // Verificar si la respuesta es exitosa
            if ($response->successful()) {
                $data = $response->json();
    
                if (isset($data['idPersona'])) {
                    // Guardar usuario en sesión
                    Session::put('usuario', [
                        'id' => $data['idPersona'],
                        'nombre' => $data['nombres'] . ' ' . $data['apellidos'],
                        'perfil' => $data['perfil'] ?? null,
                        'correo' => $data['correo'],
                        'sexo' => $data['sexo'] ?? null,
                        'rol' => $data['rol'] ?? null,
                    ]);
    
                    return response()->json([
                        'message' => 'Login exitoso',
                        'usuario' => Session::get('usuario'),
                    ]);
                }
    
                // Si las credenciales son inválidas
                return response()->json([
                    'message' => $data['msg'] ?? 'Credenciales incorrectas',
                ], 401);
            }
    
            // Manejo de errores de API
            return response()->json([
                'message' => 'Error al autenticar. Intente de nuevo.',
            ], $response->status());
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en la comunicación con el servidor.',
            ], 500);
        }
    }
    
}
