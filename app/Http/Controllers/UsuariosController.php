<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function register(Request $request)
    {
        try {
            $validacion = Validator::make($request->all(), [
                'nombre_usuario' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'fecha_nacimiento' => 'required|date',
                'direccion' => 'required|string|max:255',
                'telefono' => 'required|string|max:15',
                'genero' => 'required|string',
                'apellido' => 'required|string',
                'nombre' => 'required|string',
                'foto_perfil' => 'required_without:nombre|string|max:2048',
                'foto_portada' => 'required_without:nombre|string|max:2048'
            ]);

            if ($validacion->fails()) {
                return response()->json([
                    'code' => 400,
                    'errors' => $validacion->errors()
                ], 400);
            }

            $usuario = User::create([
                'nombre_usuario' => $request->nombre_usuario,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'apellido' => $request->apellido,
                'nombre' => $request->nombre,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'genero' => $request->genero,
                'foto_perfil' => $request->foto_perfil,
                'foto_portada' => $request->foto_portada
            ]);

            $token = $usuario->createToken('api-key')->plainTextToken;

            return response()->json([
                'code' => 200,
                'data' => $usuario,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Error en el servidor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function autentificacion(Request $request)
    {
        try {
            $validacion = Validator::make($request->all(), [
                'nombre_usuario' => 'required_without:email|string|max:255',
                'email' => 'required_without|email',
                'password' => 'required|min:8'
            ]);

            if ($validacion->fails()) {
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $usuario = User::where('email', $request->email)->first();
                    return response()->json([
                        'code' => 200,
                        'data' => $usuario,
                        'token' => $usuario->createToken('api-key')->plainTextToken
                    ], 200);
                } elseif (Auth::attempt(['nombre_usuario' => $request->nombre_usuario, 'password' => $request->password])) {
                    $usuario = User::where('nombre_usuario', $request->nombre_usuario)->first();
                    return response()->json([
                        'code' => 200,
                        'data' => $usuario,
                        'token' => $usuario->createToken('api-key')->plainTextToken
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 401,
                        'data' => 'Usuario no autorizado'
                    ], 401);
                }
            }
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            if (!$query || trim($query) === '') {
                // Cargar usuarios al azar si no se proporciona un query
                $usuarios = User::inRandomOrder()->take(10)->get();

                return response()->json([
                    'code' => 200,
                    'data' => $usuarios
                ], 200);
            }


            $usuarios = User::where('nombre_usuario', 'LIKE', "%$query%")->get();

            if ($usuarios->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'message' => 'No se encontraron usuarios'
                ], 404);
            }

            return response()->json([
                'code' => 200,
                'data' => $usuarios
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => 'Error en el servidor: ' . $th->getMessage()
            ], 500);
        }
    }

    public function actualizarRegistro(Request $request, $id)
    {
        try {
            $validacion = Validator::make($request->all(), [
                "foto_perfil" => "required_without:foto_portada|string|max:255",
                "foto_portada" => "required_without:foto_perfil|string|max:255"
            ]);

            if ($validacion->fails()) {
                return response()->json([
                    'code' => 400,
                    'data' => $validacion->messages()
                ], 400);
            } else {
                $usuario = User::find($id);

                if ($usuario) {
                    $usuario->update($request->all());
                    return response()->json([
                        'code' => 200,
                        'data' => 'Registro actualizado correctamente'
                    ]);
                } else {
                    return response()->json([
                        'code' => 404,
                        'data' => 'Foto no encontrada'
                    ]);
                }
            }
        } catch (\Throwable $th) {
            if (app()->environment('local')) {
                return response()->json($th->getMessage(), 500);
            } else {
                return response()->json([
                    'code' => 500,
                    'data' => 'Error en el servidor'
                ]);
            }
        }
    }

    //obtener Usuario por id
    public function FindUser($id)
    {
        try {
            // Se busca el estudiante
            $usuario = User::find($id);
            if ($usuario) {
                // Si existe se retorna la información en formato json
                return response()->json([
                    'code' => 200,
                    'data' => $usuario
                ], 200);
            } else {
                // Si no existe se retorna un mensaje en formato json
                return response()->json([
                    'code' => 404,
                    'data' => 'Usuario no encontrado'
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 500,
                'message' => 'Error en el servidor: ' . $th->getMessage()
            ], 500);
        }
    }
}
