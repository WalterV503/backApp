<?php

use App\Http\Controllers\FotoController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\PublicacionFotoController;
use App\Http\Controllers\TipoFotoController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/usuario/register', [UsuariosController::class, 'register']);
Route::post('/usuario/autentificacion', [UsuariosController::class, 'autentificacion']);
Route::put('/usuario/actualizar/{id}', [UsuariosController::class, 'actualizarRegistro']);
Route::get('/usuario/buscar', [UsuariosController::class, 'search']);
Route::get('/usuario/find/{id}', [UsuariosController::class, 'FindUser']);


Route::get('/tipoFoto/obtener', [TipoFotoController::class, 'index']);
Route::post('/tipoFoto/crear', [TipoFotoController::class, 'store']);
Route::put('/tipoFoto/actualizar/{id}', [TipoFotoController::class, 'update']);
Route::delete('/tipoFoto/eliminar/{id}', [TipoFotoController::class, 'destroy']);
Route::get('/tipoFoto/buscar/{id}', [TipoFotoController::class, 'search']);

Route::post('/foto/crear', [FotoController::class, 'store']);
Route::get('/foto/obtener/{id}', [FotoController::class, 'obtenerFotos']);
Route::put('/foto/actualizar/{id}', [FotoController::class, 'update']);
Route::delete('/foto/eliminar/{id}', [FotoController::class, 'destroy']);

Route::post('/publicacion/crear', [PublicacionController::class, 'store']);
Route::get('/publicacion/obtener', [PublicacionController::class, 'index']);
Route::delete('/publicacion/eliminar/{id}', [PublicacionController::class, 'destroy']);

Route::put('/publicacionFoto/actualizar/{id}', [PublicacionFotoController::class, 'update']);