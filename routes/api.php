<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/usuario/register', [UsuariosController::class, 'register']);
Route::post('/usuario/autentificacion', [UsuariosController::class, 'autentificacion']);
