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
                'nombre' => 'required|string'
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
                'genero' => $request->genero
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
                'email' => 'required|email',
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
}