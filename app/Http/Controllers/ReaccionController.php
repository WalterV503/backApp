<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReaccionModel;
use Illuminate\Support\Facades\Validator;

class ReaccionController extends Controller
{
    // EndPoint para obtener un listado de las reacciones
    public function select()
    {
        try {
            $reacciones = ReaccionModel::select(
                'reaccion.id',
                'usuario.id as usuario_id',
                'usuario.nombre_usuario as usuario_nombre',
                'publicacion.id as publicacion_id',
                'publicacion.contenido as contenido',
                'tipo_reaccion.Nombre_Reaccion as tipo_reaccion',
                'reaccion.fecha_reaccion'
            )
                ->join('usuario', 'reaccion.fk_usuario_id', '=', 'usuario.id')
                ->join('publicacion', 'reaccion.fk_publicacion_id', '=', 'publicacion.id')
                ->join('tipo_reaccion', 'reaccion.fk_tipoReaccion_id', '=', 'tipo_reaccion.id')
                ->get();
            if ($reacciones->count() > 0) {
                // Si hay reacciones se retorna el listado en un json
                return response()->json([
                    'code' => 200,
                    'data' => $reacciones
                ], 200);
            } else {
                // Si no hay reacciones se muestra un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'No hay reacciones'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // EndPoint para insertar una reaccion
    public function store(Request $request)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'fk_usuario_id' => 'required',
                'fk_publicacion_id' => 'required',
                'fk_tipoReaccion_id' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validacion se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validacion se inserta la reaccion
                $reaccion = ReaccionModel::create($request->all());

                return response()->json([
                    'code' => 200,
                    'data' => 'Reacción insertada'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // EndPoint para modificar una reaccion
    public function update(Request $request, $id)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'fk_usuario_id' => 'required',
                'fk_publicacion_id' => 'required',
                'fk_tipoReaccion_id' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validacion se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validacion se busca la reaccion
                $reaccion = ReaccionModel::find($id);
                if ($reaccion) {
                    // Si la reaccion existe se actualiza
                    $reaccion->update($request->all());
                    return response()->json([
                        'code' => 200,
                        'data' => 'Reacción actualizada'
                    ], 200);
                } else {
                    // Si la reaccion no existe se devuelve el mensaje
                    return response()->json([
                        'code' => 404,
                        'data' => 'Reacción no encontrada'
                    ], 404);
                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // Endpoint para eliminar una reaccion
    public function delete($id)
    {
        try {
            // Se busca la reaccion 
            $reaccion = ReaccionModel::find($id);
            if ($reaccion) {
                // Si la reaccion existe se elimina
                $reaccion->delete($id);
                return response()->json([
                    'code' => 200,
                    'data' => 'Reacción eliminada'
                ], 200);
            } else {
                // Si la reaccion no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Reacción no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // Endpoint para buscar una reaccion
    public function find($id)
    {
        try {
            // Se busca la reaccion 
            $reaccion = ReaccionModel::find($id);
            if ($reaccion) {
                // Si la reaccion existe se retornan sus datos  
                $datos = ReaccionModel::select(
                    'reaccion.id',
                    'usuario.id as usuario_id',
                    'usuario.nombre_usuario as usuario_nombre',
                    'publicacion.id as publicacion_id',
                    'publicacion.contenido as contenido',
                    'tipo_reaccion.Nombre_Reaccion as tipo_reaccion',
                    'reaccion.fecha_reaccion'
                )
                    ->join('usuario', 'reaccion.fk_usuario_id', '=', 'usuario.id')
                    ->join('publicacion', 'reaccion.fk_publicacion_id', '=', 'publicacion.id')
                    ->join('tipo_reaccion', 'reaccion.fk_tipoReaccion_id', '=', 'tipo_reaccion.id')
                    ->where('reaccion.id', '=', $id)
                    ->get();
                return response()->json([
                    'code' => 200,
                    'data' => $datos[0]
                ], 200);
            } else {
                // Si la reaccion no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Reacción no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
