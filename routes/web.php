<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/maestros', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('administracion.maestros')]);
    }
    return view('administracion.maestros');
});

Route::get('/alumnos', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('administracion.alumnos')]);
    }
    return view('administracion.alumnos');
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

Route::get('/bloques', function () {
    if (request()->ajax()) {
        return view('content')->with(['contenido' => view('administracion.bloques')]);
    }
    return view('administracion.bloques');
});