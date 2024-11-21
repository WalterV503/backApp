<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MensajeModel;
use Illuminate\Support\Facades\Validator;

class MensajeController extends Controller
{
    // EndPoint para obtener un listado de los mensajes
    public function select()
    {
        try {
            $mensajes = MensajeModel::select(
                'mensaje.id',
                'emisor.id as usuario_emisor_id',
                'emisor.nombre_usuario as usuario_emisor_nombre',
                'receptor.id as usuario_receptor_id',
                'receptor.nombre_usuario as usuario_receptor_nombre',
                'mensaje.contenido',
                'mensaje.estado',
                'mensaje.tipo_mensaje',
                'mensaje_referencia.contenido as referencia_mensaje',
                'mensaje.fecha_envio'
            )
                ->join('usuario as emisor', 'mensaje.fk_usuario_emisor_id', '=', 'emisor.id')
                ->join('usuario as receptor', 'mensaje.fk_usuario_receptor_id', '=', 'receptor.id')
                ->leftJoin('mensaje as mensaje_referencia', 'mensaje.referencia_mensaje', '=', 'mensaje_referencia.id')
                ->get();
            if ($mensajes->count() > 0) {
                // Si hay mensajes se retorna el listado en un json
                return response()->json([
                    'code' => 200,
                    'data' => $mensajes
                ], 200);
            } else {
                // Si no hay mensajes se muestra un mensaje
                return response()->json([
                    'code' => 404,
                    'data' => 'No hay mensajes'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // EndPoint para insertar un mensaje
    public function store(Request $request)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'fk_usuario_emisor_id' => 'required',
                'fk_usuario_receptor_id' => 'required',
                'contenido' => 'required',
                'estado' => 'required',
                'tipo_mensaje' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validacion se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validacion se inserta el mensaje
                $mensaje = MensajeModel::create($request->all());

                return response()->json([
                    'code' => 200,
                    'data' => 'Mensaje insertado'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // EndPoint para modificar un mensaje
    public function update(Request $request, $id)
    {
        try {
            // Se valida que todos los campos sean requeridos
            $validacion = Validator::make($request->all(), [
                'fk_usuario_emisor_id' => 'required',
                'fk_usuario_receptor_id' => 'required',
                'contenido' => 'required',
                'estado' => 'required',
                'tipo_mensaje' => 'required'
            ]);

            if ($validacion->fails()) {
                // Si no se cumple la validacion se devuelve el mensaje de error
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                // Si se cumple la validacion se busca el mensaje
                $mensaje = MensajeModel::find($id);
                if ($mensaje) {
                    // Si el mensaje existe se actualiza
                    $mensaje->update($request->all());
                    return response()->json([
                        'code' => 200,
                        'data' => 'Mensaje actualizado'
                    ], 200);
                } else {
                    // Si el mensaje no existe se devuelve el mensaje
                    return response()->json([
                        'code' => 404,
                        'data' => 'Mensaje no encontrado'
                    ], 404);
                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // Endpoint para eliminar un mensaje
    public function delete($id)
    {
        try {
            // Se busca el mensaje 
            $mensaje = MensajeModel::find($id);
            if ($mensaje) {
                // Si el mensaje existe se elimina
                $mensaje->delete($id);
                return response()->json([
                    'code' => 200,
                    'data' => 'Mensaje eliminado'
                ], 200);
            } else {
                // Si el mensaje no existe se devuelve una advertencia
                return response()->json([
                    'code' => 404,
                    'data' => 'Mensaje no encontrado'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    // Endpoint para buscar un mensaje
    public function find($id)
    {
        try {
            // Se busca el mensaje 
            $mensaje = MensajeModel::find($id);
            if ($mensaje) {
                // Si el mensaje existe se retornan sus datos  
                $datos = MensajeModel::select(
                    'mensaje.id',
                    'emisor.id as usuario_emisor_id',
                    'emisor.nombre_usuario as usuario_emisor_nombre',
                    'receptor.id as usuario_receptor_id',
                    'receptor.nombre_usuario as usuario_receptor_nombre',
                    'mensaje.contenido',
                    'mensaje.estado',
                    'mensaje.tipo_mensaje',
                    'mensaje_referencia.contenido as referencia_mensaje',
                    'mensaje.fecha_envio'
                )
                    ->join('usuario as emisor', 'mensaje.fk_usuario_emisor_id', '=', 'emisor.id')
                    ->join('usuario as receptor', 'mensaje.fk_usuario_receptor_id', '=', 'receptor.id')
                    ->leftJoin('mensaje as mensaje_referencia', 'mensaje.referencia_mensaje', '=', 'mensaje_referencia.id')
                    ->where('mensaje.id', '=', $id)
                    ->get();
                return response()->json([
                    'code' => 200,
                    'data' => $datos[0]
                ], 200);
            } else {
                // Si el mensaje no existe se devuelve una advertencia
                return response()->json([
                    'code' => 404,
                    'data' => 'Mensaje no encontrado'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
