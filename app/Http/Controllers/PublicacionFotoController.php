<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublicacionFotoModel;
use Illuminate\Support\Facades\Validator;

class PublicacionFotoController extends Controller
{
    // EndPoint para obtener un listado de publicacion_foto
    public function select()
    {
        try {
            $publicaciones_fotos = PublicacionFotoModel::select(
                'publicacion.id as publicacion_id',
                'publicacion.fk_usuario_id as usuario_publicacion_id',
                'publicacion.contenido',
                'publicacion.fecha_publicacion',
                'foto.id as foto_id',
                'foto.fk_usuario_id as usuario_foto_id',
                'foto.fk_tipoFoto_id as tipo_foto_id',
                'foto.url_foto',
                'foto.fecha_subida as fecha_foto',
            )
                ->join('publicacion', 'publicacion_foto.fk_publicacion_id', '=', 'publicacion.id')
                ->join('foto', 'publicacion_foto.fk_foto_id', '=', 'foto.id')
                ->get();
            if ($publicaciones_fotos->count() > 0) {
                // Si hay publicaciones_fotos se retorna el listado en un json
                return response()->json([
                    'code' => 200,
                    'data' => $publicaciones_fotos
                ], 200);
            } else {
                // Si no hay publicaciones_fotos se muestra un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'No hay publicaciones_fotos'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // EndPoint para insertar una publicacion_foto
    public function store(Request $request)
    {
        try {
            // Validación de los campos requeridos
            $validacion = Validator::make($request->all(), [
                'fk_publicacion_id' => 'required',
                'fk_foto_id' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validación, se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Verificar si ya existe la combinación antes de insertar
                $existe = PublicacionFotoModel::where('fk_publicacion_id', $request->fk_publicacion_id)
                    ->where('fk_foto_id', $request->fk_foto_id)
                    ->exists();

                if ($existe) {
                    // Si la combinación ya existe, se devuelve un mensaje de error
                    return response()->json([
                        'code' => 409,
                        'data' => 'La combinación de publicacion y foto ya existe'
                    ], 409);
                }

                // Si no existe la combinación, se inserta la publicacion_foto
                $publicacion_foto = PublicacionFotoModel::create($request->all());

                return response()->json([
                    'code' => 200,
                    'data' => 'Publicacion_foto insertada'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function update(Request $request, $fk_publicacion_id, $fk_foto_id)
    {
        try {
            // Validación de los campos requeridos
            $validacion = Validator::make($request->all(), [
                'fk_publicacion_id' => 'required',
                'fk_foto_id' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validación, se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Verificar si la nueva combinación ya existe
                $existe = PublicacionFotoModel::where('fk_publicacion_id', $request->fk_publicacion_id)
                    ->where('fk_foto_id', $request->fk_foto_id)
                    ->first();

                if ($existe) {
                    // Si la combinación ya existe, devolver error 409
                    return response()->json([
                        'code' => 409,
                        'data' => 'La combinación de publicacion_id y foto_id ya existe'
                    ], 409);
                }

                // Se verifica si existe la publicacion_foto que se desea actualizar
                $publicacion_foto = PublicacionFotoModel::where('fk_publicacion_id', $fk_publicacion_id)
                    ->where('fk_foto_id', $fk_foto_id)
                    ->first();

                if ($publicacion_foto) {
                    // Realizar la actualización manualmente con query builder
                    PublicacionFotoModel::where('fk_publicacion_id', $fk_publicacion_id)
                        ->where('fk_foto_id', $fk_foto_id)
                        ->update([
                            'fk_publicacion_id' => $request->fk_publicacion_id,
                            'fk_foto_id' => $request->fk_foto_id,
                            'updated_at' => now(),
                        ]);

                    return response()->json([
                        'code' => 200,
                        'data' => 'Publicacion_foto actualizada'
                    ], 200);
                } else {
                    // Si la publicacion_foto no existe, se devuelve el mensaje
                    return response()->json([
                        'code' => 404,
                        'data' => 'Publicacion_foto no encontrada'
                    ], 404);
                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function delete($fk_publicacion_id, $fk_foto_id)
    {
        try {
            // Se intenta eliminar la publicacion_foto usando Query Builder
            $deleted = PublicacionFotoModel::where('fk_publicacion_id', $fk_publicacion_id)
                ->where('fk_foto_id', $fk_foto_id)
                ->delete();

            if ($deleted) {
                // Si la eliminación fue exitosa
                return response()->json([
                    'code' => 200,
                    'data' => 'Publicacion_foto eliminada'
                ], 200);
            } else {
                // Si la publicacion_foto no existe o no se pudo eliminar
                return response()->json([
                    'code' => 404,
                    'data' => 'Publicacion_foto no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // Endpoint para buscar una publicacion_foto
    public function find($fk_publicacion_id, $fk_foto_id)
    {
        try {
            // Se busca la publicacion_foto por la clave primaria compuesta
            $publicacion_foto = PublicacionFotoModel::where('fk_publicacion_id', $fk_publicacion_id)
                ->where('fk_foto_id', $fk_foto_id)
                ->first();

            if ($publicacion_foto) {
                // Si la publicacion_foto existe se retornan sus datos
                $datos = PublicacionFotoModel::select(
                    'publicacion.id as publicacion_id',
                    'publicacion.fk_usuario_id as usuario_publicacion_id',
                    'publicacion.contenido',
                    'publicacion.fecha_publicacion',
                    'foto.id as foto_id',
                    'foto.fk_usuario_id as usuario_foto_id',
                    'foto.fk_tipoFoto_id as tipo_foto_id',
                    'foto.url_foto',
                    'foto.fecha_subida as fecha_foto'
                )
                    ->join('publicacion', 'publicacion_foto.fk_publicacion_id', '=', 'publicacion.id')
                    ->join('foto', 'publicacion_foto.fk_foto_id', '=', 'foto.id')
                    ->where('publicacion_foto.fk_publicacion_id', $fk_publicacion_id)
                    ->where('publicacion_foto.fk_foto_id', $fk_foto_id)
                    ->get();

                return response()->json([
                    'code' => 200,
                    'data' => $datos->first()
                ], 200);
            } else {
                // Si la publicacion_foto no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Publicacion_foto no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
