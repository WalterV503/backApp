<?php

namespace App\Http\Controllers;

use App\Models\FotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function obtenerFotos($id)
    {
        try {
            $foto = FotoModel::where('fk_usuario_id', $id)->get();

            if ($foto) {
                return response()->json([
                    'code' => 200,
                    'data' => $foto
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                    'data' => 'No se encontraron fotos del usuario'
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

            $validaciones = Validator::make($request->all(), [
                'fk_usuario_id' => 'required|exists:usuario,id',
                'fk_tipoFoto_id' => 'required|exists:tipo_foto,id',
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validaciones->fails()) {
                return response()->json([
                    'code' => 400,
                    'data' => $validaciones->messages()
                ], 400);
            }

            $path = $request->file('photo')->store('photos', 'public');

            $foto = FotoModel::create([
                'fk_usuario_id' => $validaciones->validated()['fk_usuario_id'],
                'fk_tipoFoto_id' => $validaciones->validated()['fk_tipoFoto_id'],
                'url_foto' => $path,
                'fecha_subida' => now(),
            ]);

            return response()->json([
                'message' => 'Foto subida y guardada correctamente.',
                'data' => $foto,
            ], 201);
        } catch (\Throwable $th) {
            if (app()->environment('local')) {
                return response()->json(['error' => $th->getMessage()], 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidor'
            ], 500);
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
    public function update(Request $request, $id)
    {
        try {
            $validaciones = Validator::make($request->all(), [
                'fk_usuario_id' => 'nullable|exists:usuario,id',
                'fk_tipoFoto_id' => 'nullable|exists:tipo_foto,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validaciones->fails()) {
                return response()->json([
                    'code' => 400,
                    'data' => $validaciones->messages(),
                ], 400);
            } else {
                $foto = FotoModel::find($id);

                if ($foto) {
                    // Si se sube una nueva foto, eliminar la foto anterior
                    if ($request->hasFile('photo')) {
                        // Verificar si la foto anterior existe y eliminarla
                        $rutaAnterior = public_path('storage/' . $foto->url_foto);
                        if (file_exists($rutaAnterior)) {
                            unlink($rutaAnterior); // Eliminar la foto físicamente
                        }

                        // Subir la nueva imagen y obtener la ruta
                        $path = $request->file('photo')->store('photos', 'public');

                        // Actualizar la URL de la foto
                        $foto->url_foto = Storage::url($path);
                    }

                    $foto->fk_usuario_id = $request->input('fk_usuario_id', $foto->fk_usuario_id);
                    $foto->fk_tipoFoto_id = $request->input('fk_tipoFoto_id', $foto->fk_tipoFoto_id);
                    $foto->fecha_subida = now();

                    $foto->save();

                    return response()->json([
                        'message' => 'Foto actualizada correctamente.',
                        'data' => $foto,
                    ], 200);
                } else {
                    return response()->json([
                        'code' => 404,
                        'data' => 'Foto no encontrada',
                    ], 404);
                }
            }
        } catch (\Throwable $th) {
            if (app()->environment('local')) {
                return response()->json($th->getMessage(), 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidor',
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $foto = FotoModel::find($id);

            if ($foto) {
                $ruta = public_path('storage/' . $foto->url_foto);

                if (file_exists($ruta)) {
                    unlink($ruta);
                }

                $foto->delete();

                return response()->json([
                    'code' => '200.',
                    'data' => 'Foto eliminada correctamente'
                ], 200);
            } else {
                return response()->json([
                    'code' => 400,
                    'data' => 'La foto no se encuentra en nuestros registros'
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
