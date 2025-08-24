<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas de autenticación (públicas)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/cambiar-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
Route::post('/cambiar-password', [AuthController::class, 'changePassword']);
Route::get('/cambiar-perfil', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('auth.change-perfil')]);
    }
    return view('auth.change-perfil');
});    
Route::get('/eventos-proximos', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('general.eventos')]);
    }
    return view('general.eventos');
});    

// Rutas exclusivas para Supervisores (rol P) - Acceso completo
Route::middleware(['auth.supervisor'])->group(function () {
    Route::get('/modo', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('general.modo')]);
        }
        return view('general.modo');
    });
});

// Rutas de Administración (roles G y P)
Route::middleware(['auth.admin'])->group(function () {
    // Dashboard principal de administración
    Route::get('/', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.index')]);
        }
        return view('administracion.index');
    });
    // Configuración de institución
    Route::get('/institucion', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.formularios.form-institucion')]);
        }
        return view('administracion.formularios.form-institucion');
    });

    // Gestión de períodos
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

    // Gestión de carreras
    Route::get('/carreras', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.carreras')]);
        }
        return view('administracion.carreras');
    });

    // Gestión de usuarios
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

    // Gestión de materias
    Route::get('/materias', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.materias')]);
        }
        return view('administracion.materias');
    });

    // Gestión de grados
    Route::get('/grados', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.grados')]);
        }
        return view('administracion.grados');
    });

    // Gestión de precios
    Route::get('/precios', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.precios')]);
        }
        return view('administracion.precios');
    });

    Route::get('/eventos', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.eventos')]);
        }
        return view('administracion.eventos');
    });    

    // Administración de grados
    Route::get('/administracion-grados', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.administracion-grados')]);
        }
        return view('administracion.administracion-grados');
    });

    // Administración de pagos
    Route::get('/administracion-pagos', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.administracion-pagos')]);
        }
        return view('administracion.administracion-pagos');
    });

    Route::get('/pagos/{id}', function ($id) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('administracion.pagos-usuario', ['id' => $id])
            ]);
        }
        return view('administracion.pagos-usuario', ['id' => $id]);
    });

    // Administración de grados - Vistas específicas
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

    Route::get('/administracion-grados/calendario/{id}/{otroId}', function ($id, $otroId) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('administracion.administracion-grados-views.calendario', [
                    'id' => $id,
                    'otroId' => $otroId
                ])
            ]);
        }
        return view('administracion.administracion-grados-views.calendario', [
            'id' => $id,
            'otroId' => $otroId
        ]);
    });

    Route::get('/administracion-grados/alumnos/{id}/{otroId}', function ($id, $otroId) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('administracion.administracion-grados-views.alumnos', [
                    'id' => $id,
                    'otroId' => $otroId
                ])
            ]);
        }
        return view('administracion.administracion-grados-views.alumnos', [
            'id' => $id,
            'otroId' => $otroId
        ]);
    });

    // Actualización de notas
    Route::get('/actualiza-notas', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.formularios.form-actualizar')]);
        }
        return view('administracion.formularios.form-actualizar');
    });

    Route::get('/notas-alumnos/{id}', function ($id) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('administracion.notas-alumnos', ['id' => $id])
            ]);
        }
        return view('administracion.notas-alumnos', ['id' => $id]);
    });
    Route::get('/resultados-alumnos', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.resultados-alumnos')]);
        }
        return view('administracion.resultados-alumnos');
    });    
});

// Rutas de Maestros (roles M y P)
Route::middleware(['auth.maestro'])->prefix('maestro')->group(function () {
    // Dashboard de maestros
    Route::get('/', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('maestros.index')]);
        }
        return view('maestros.index');
    });

    // Mis clases
    Route::get('/mis-clases', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('maestros.mis-clases')]);
        }
        return view('maestros.mis-clases');
    });

    // Evaluaciones
    Route::get('/evaluaciones/{periodo}/{grado}/{materia}', function ($periodo, $grado, $materia) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('maestros.evaluaciones', [
                    'periodo' => $periodo,
                    'grado' => $grado,
                    'materia' => $materia
                ])
            ]);
        }
        return view('maestros.evaluaciones', [
            'periodo' => $periodo,
            'grado' => $grado,
            'materia' => $materia
        ]);
    });

    // Puntuación específica
    Route::get('/evaluaciones/{periodo}/{grado}/{materia}/{bloque}/{orden}', function ($periodo, $grado, $materia, $bloque, $orden) {
        if (request()->ajax()) {
            return view('content')->with([
                'contenido' => view('maestros.puntuacion', [
                    'periodo' => $periodo,
                    'grado' => $grado,
                    'materia' => $materia,
                    'bloque' => $bloque,
                    'orden' => $orden
                ])
            ]);
        }
        return view('maestros.puntuacion', [
            'periodo' => $periodo,
            'grado' => $grado,
            'materia' => $materia,
            'bloque' => $bloque,
            'orden' => $orden
        ]);
    });
});

// Rutas para Alumnos (solo rol A)
Route::middleware(['auth.alumno'])->prefix('alumno')->group(function () {
    // Dashboard de alumnos
    Route::get('/', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('alumnos.index')]);
        }
        return view('alumnos.index');
    });

    // Notas del alumno
    Route::get('/notas', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('alumnos.notas')]);
        }
        return view('alumnos.notas');
    });

    // Calendario del alumno
    Route::get('/pagos', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('alumnos.pagos')]);
        }
        return view('alumnos.pagos');
    });
    Route::get('/calendario', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('alumnos.calendario')]);
        }
        return view('alumnos.calendario');
    });    
});