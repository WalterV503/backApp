<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PublicacionModel;
use App\Models\PublicacionFotoModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $publicaciones = PublicacionModel::all();
            if ($publicaciones->count() > 0) {
                return response()->json([
                    'code' => 200,
                    'data' => $publicaciones
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'data' => 'No se encontraron publicaciones'
                ]);
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        // Validar los datos recibidos
        $validaciones = Validator::make($request->all(), [
            'fk_usuario_id' => 'required|exists:usuario,id',
            'contenido' => 'required|string|max:255',
            'url_publicacion' => 'required|string|max:255',
            'fk_foto_id' => 'required|exists:foto,id', // ID de la foto es obligatorio
        ]);

        if ($validaciones->fails()) {
            return response()->json([
                'code' => 400,
                'data' => $validaciones->messages()
            ], 400);
        }

        // Crear la publicación
        $publicacion = PublicacionModel::create($request->only('fk_usuario_id', 'contenido', 'url_publicacion'));

        // Crear la relación con la foto
        $dataPublicacionFoto = [
            'fk_publicacion_id' => $publicacion->id,
            'fk_foto_id' => $request->fk_foto_id,
        ];

        PublicacionFotoModel::create($dataPublicacionFoto);

        return response()->json([
            'code' => 201,
            'message' => 'Publicación y relación con la foto creadas exitosamente.',
            'data' => $publicacion,
        ], 201);
    } catch (\Throwable $th) {
        // Manejo de excepciones
        if (app()->environment('local')) {
            return response()->json(['error' => $th->getMessage()], 500);
        } else {
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidor',
            ], 500);
        }
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $publicaciones = PublicacionModel::find($id);
            if ($publicaciones) {
                $publicaciones->delete();
                return response()->json([
                    'code' => 200,
                    'data' => 'Publicación eliminada correctamente'
                ]);
            } else {
                return response()->json([
                    'code' => 404,
                    'data' => 'Publicación no encontrada'
                ]);
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
}
