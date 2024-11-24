<?php

use App\Http\Controllers\MensajeController;
use App\Http\Controllers\PublicacionFotoController;
use App\Http\Controllers\ReaccionController;
use App\Http\Controllers\TipoReaccionController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/usuario/register', [UsuariosController::class, 'register']);
Route::post('/usuario/autentificacion', [UsuariosController::class, 'autentificacion']);

































/*
    GESTION DE LA TABLA 'REACCION'
*/
Route::get('/reaccion/select', [ReaccionController::class, 'select']); 
Route::post('/reaccion/store', [ReaccionController::class, 'store']); 
Route::put('/reaccion/update/{id}', [ReaccionController::class, 'update']); 
Route::delete('/reaccion/delete/{id}', [ReaccionController::class, 'delete']); 
Route::get('/reaccion/find/{id}', [ReaccionController::class, 'find']);

/*
    GESTION DE LA TABLA 'TIPO_REACCION'
*/
Route::get('/tipo_reaccion/select', [TipoReaccionController::class, 'select']); 
Route::post('/tipo_reaccion/store', [TipoReaccionController::class, 'store']);
Route::put('/tipo_reaccion/update/{id}', [TipoReaccionController::class, 'update']);
Route::delete('/tipo_reaccion/delete/{id}', [TipoReaccionController::class, 'delete']);
Route::get('/tipo_reaccion/find/{id}', [TipoReaccionController::class, 'find']);

/*
    GESTION DE LA TABLA 'MENSAJE'
*/
Route::get('/mensaje/select', [MensajeController::class, 'select']); 
Route::post('/mensaje/store', [MensajeController::class, 'store']);
Route::put('/mensaje/update/{id}', [MensajeController::class, 'update']);
Route::delete('/mensaje/delete/{id}', [MensajeController::class, 'delete']);
Route::get('/mensaje/find/{id}', [MensajeController::class, 'find']);

/*
    GESTION DE LA TABLA 'PUBLICACION_FOTO' ***ELIMINADO***
*/
// Route::get('/publicacion_foto/select', [PublicacionFotoController::class, 'select']); 
// Route::post('/publicacion_foto/store', [PublicacionFotoController::class, 'store']);
// Route::put('/publicacion_foto/update/{fk_publicacion_id}/{fk_foto_id}', [PublicacionFotoController::class, 'update']);
// Route::delete('/publicacion_foto/delete/{fk_publicacion_id}/{fk_foto_id}', [PublicacionFotoController::class, 'delete']);
// Route::get('/publicacion_foto/find/{fk_publicacion_id}/{fk_foto_id}', [PublicacionFotoController::class, 'find']);