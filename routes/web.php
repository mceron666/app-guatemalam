<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware para verificar si el usuario está autenticado
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/modo', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('general.modo')]);
        }
        return view('general.modo');
    });             
    //Administración
    Route::get('/', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.index')]);
        }
        return view('administracion.index');
    });
    Route::get('/institucion', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.formularios.form-institucion')]);
        }
        return view('administracion.formularios.form-institucion');
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
    Route::get('/precios', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.precios')]);
        }
        return view('administracion.precios');
    });    
    Route::get('/administracion-grados', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('administracion.administracion-grados')]);
        }
        return view('administracion.administracion-grados');
    });  
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
    //Maestros
    Route::get('maestro/', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('maestros.index')]);
        }
        return view('maestros.index');
    });    
    Route::get('maestro/mis-clases', function () {
        if (request()->ajax()) {
            return view('content')->with(['contenido' => view('maestros.mis-clases')]);
        }
        return view('maestros.mis-clases');
    });       
    Route::get('maestro/evaluaciones/{periodo}/{grado}/{materia}', function ($periodo, $grado, $materia) {
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
Route::get('maestro/evaluaciones/{periodo}/{grado}/{materia}/{bloque}/{orden}', function ($periodo, $grado, $materia, $bloque, $orden) {
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
//Alumnos
Route::get('alumno/', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('alumnos.index')]);
    }
    return view('alumnos.index');
});    
Route::get('alumno/notas', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('alumnos.notas')]);
    }
    return view('alumnos.notas');
});  
Route::get('alumno/calendario', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('alumnos.calendario')]);
    }
    return view('alumnos.calendario ');
});           
});
