<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\Apis\UsuariosController;
use App\Http\Controllers\Apis\PeriodosController;

Route::middleware(['authsession'])->group(function () {
    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Acceso permitido']);
    });
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::resource(name: 'usuarios', controller: UsuariosController::class);
Route::resource(name: 'periodos', controller: PeriodosController::class);
