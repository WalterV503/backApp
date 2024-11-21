<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoReaccionModel;
use Illuminate\Support\Facades\Validator;

class TipoReaccionController extends Controller
{
    // EndPoint para obtener un listado de tipo_reaccion
    public function select()
    {
        try {
            $tipo_reaccion = TipoReaccionModel::select(
                'tipo_reaccion.id',
                'tipo_reaccion.Nombre_Reaccion'
            )
                ->get();
            if ($tipo_reaccion->count() > 0) {
                // Si hay tipo_reaccion se retorna el listado en un json
                return response()->json([
                    'code' => 200,
                    'data' => $tipo_reaccion
                ], 200);
            } else {
                // Si no hay tipo_reaccion se muestra un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'No hay Tipos Reacción'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // EndPoint para insertar tipo_reaccion
    public function store(Request $request)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'Nombre_Reaccion' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validacion se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validacion se inserta tipo_reaccion
                $tipo_reaccion = TipoReaccionModel::create($request->all());

                return response()->json([
                    'code' => 200,
                    'data' => 'Tipo Reacción insertada'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // EndPoint para modificar tipo_reaccion
    public function update(Request $request, $id)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'Nombre_Reaccion' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validacion se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validacion se busca la tipo_reaccion
                $tipo_reaccion = TipoReaccionModel::find($id);
                if ($tipo_reaccion) {
                    // Si la tipo_reaccion existe se actualiza
                    $tipo_reaccion->update($request->all());
                    return response()->json([
                        'code' => 200,
                        'data' => 'Tipo Reacción actualizada'
                    ], 200);
                } else {
                    // Si la tipo_reaccion no existe se devuelve el mensaje
                    return response()->json([
                        'code' => 404,
                        'data' => 'Tipo Reacción no encontrada'
                    ], 404);
                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // Endpoint para eliminar una tipo_reaccion
    public function delete($id)
    {
        try {
            // Se busca la tipo_reaccion 
            $tipo_reaccion = TipoReaccionModel::find($id);
            if ($tipo_reaccion) {
                // Si la tipo_reaccion existe se elimina
                $tipo_reaccion->delete($id);
                return response()->json([
                    'code' => 200,
                    'data' => 'Tipo Reacción eliminada'
                ], 200);
            } else {
                // Si la tipo_reaccion no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Tipo Reacción no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // Endpoint para buscar una tipo_reaccion
    public function find($id)
    {
        try {
            // Se busca la tipo_reaccion 
            $tipo_reaccion = TipoReaccionModel::find($id);
            if ($tipo_reaccion) {
                // Si la tipo_reaccion existe se retornan sus datos  
                $datos = TipoReaccionModel::select(
                    'tipo_reaccion.id',
                    'tipo_reaccion.Nombre_Reaccion'
                )
                    ->where('tipo_reaccion.id', '=', $id)
                    ->get();
                return response()->json([
                    'code' => 200,
                    'data' => $datos[0]
                ], 200);
            } else {
                // Si la tipo_reaccion no existe se devuelve un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'Tipo Reacción no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
