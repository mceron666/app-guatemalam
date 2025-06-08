<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware para verificar si el usuario está autenticado
Route::middleware(['auth.custom'])->group(function () {
    // Ruta para la página de inicio
    Route::get('/', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.index')]);
        }
        return view('administracion.index');
    });

    Route::get('/periodos', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.periodos')]);
        }
        return view('administracion.periodos');
    });

    Route::get('/agregar-periodo', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.formularios.form-periodos')]);
        }
        return view('administracion.formularios.form-periodos');
    });

    Route::get('/modificar-periodo/{id}', function ($id) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('administracion.formularios.form-periodos', ['id' => $id])
            ]);
        }
        return view('administracion.formularios.form-periodos', ['id' => $id]);
    });    

    Route::get('/carreras', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.carreras')]);
        }
        return view('administracion.carreras');
    });

    Route::get('/usuarios', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.usuarios')]);
        }
        return view('administracion.usuarios');
    });

    Route::get('/agregar-usuario', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.formularios.form-usuarios')]);
        }
        return view('administracion.formularios.form-usuarios');
    });

    Route::get('/modificar-usuario/{id}', function ($id) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('administracion.formularios.form-usuarios', ['id' => $id])
            ]);
        }
        return view('administracion.formularios.form-usuarios', ['id' => $id]);
    });

    Route::get('/materias', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.materias')]);
        }
        return view('administracion.materias');
    });

    Route::get('/grados', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.grados')]);
        }
        return view('administracion.grados');
    });
    Route::get('/administracion-grados', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.administracion-grados')]);
        }
        return view('administracion.administracion-grados');
    });    
    Route::get('/administracion-grados/materias/{id}/{otroId}', function ($id, $otroId) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('administracion.administracion-grados-views.materias', [
                    'id' => $id,
                    'otroId' => $otroId
                ])
            ]);
        }
        return view('administracion.administracion-grados-views.materias', [
            'id' => $id,
            'otroId' => $otroId
        ]);
    });
    
});
