<?php

namespace App\Http\Controllers;

use App\Models\FotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'contenido' => 'nullable|string|max:255', 
            ]);

            if ($validaciones->fails()) {
                return response()->json([
                    'code' => 400,
                    'data' => $validaciones->messages()
                ], 400);
            }


            $path = $request->file('photo')->store('photos', 'public');
            $urlFoto = Storage::url($path); 


            $foto = FotoModel::create([
                'fk_usuario_id' => $validaciones->validated()['fk_usuario_id'],
                'fk_tipoFoto_id' => $validaciones->validated()['fk_tipoFoto_id'],
                'url_foto' => $path,
                'fecha_subida' => now(),
            ]);

            $usuarioId = $validaciones->validated()['fk_usuario_id'];
            $tipoFotoId = $validaciones->validated()['fk_tipoFoto_id'];

            $dataToUpdate = [];
            if ($tipoFotoId == 1) {
                $dataToUpdate = ['foto_perfil' => $urlFoto];
            } elseif ($tipoFotoId == 3) {
                $dataToUpdate = ['foto_portada' => $urlFoto];
            }

            if (!empty($dataToUpdate)) {
                $response = Http::put("http://127.0.0.1:8000/api/usuario/actualizar/{$usuarioId}", $dataToUpdate);

                if (!$response->successful()) {
                    return response()->json([
                        'code' => 500,
                        'data' => 'Error al actualizar el usuario en la API externa.'
                    ], 500);
                }
            } else {
                if ($tipoFotoId == 2) {
                    $dataCreatePublicacion = [
                        'fk_usuario_id' => $usuarioId,
                        'url_publicacion' => $urlFoto,
                        'contenido' => $request->contenido,
                        'fk_foto_id' => $foto->id
                    ];

                    $response = Http::post("http://127.0.0.1:8000/api/publicacion/crear", $dataCreatePublicacion);

                    if (!$response->successful()) {
                        return response()->json([
                            'code' => 500,
                            'data' => 'Error al crear la publicación en la API externa.'
                        ], 500);
                    } else {
                        
                        return response()->json([
                            'code' => 201,
                            'message' => 'Foto subida y procesada correctamente.',
                            'data' => $foto,
                        ], 201);
                    }
                }
            }
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
                'fk_usuario_id' => 'required|exists:usuario,id',
                'fk_tipoFoto_id' => 'required|exists:tipo_foto,id',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if ($validaciones->fails()) {
                return response()->json([
                    'code' => 400,
                    'data' => $validaciones->messages()
                ], 400);
            }
            $foto = FotoModel::find($id);

            if ($foto) {

                if ($request->hasFile('photo')) {
                    $rutaAnterior = public_path('storage/' . $foto->url_foto);
                    if (file_exists($rutaAnterior)) {
                        unlink($rutaAnterior);
                    }
                    $path = $request->file('photo')->store('photos', 'public');
                    $foto->url_foto = Storage::url($path);
                }

                $foto->update($request->except(['photo']));

                $usuarioId = $validaciones->validated()['fk_usuario_id'];
                $tipoFotoId = $validaciones->validated()['fk_tipoFoto_id'];
                $urlFoto = $foto->url_foto;

                $dataToUpdate = [];
                if ($tipoFotoId == 1) {
                    $dataToUpdate = ['foto_perfil' => $urlFoto];
                } elseif ($tipoFotoId == 3) {
                    $dataToUpdate = ['foto_portada' => $urlFoto];
                }

                $response = Http::put("http://127.0.0.1:8000/api/usuario/actualizar/{$usuarioId}", $dataToUpdate);

                if ($response->successful()) {
                    return response()->json([
                        'code' => 200,
                        'data' => 'Foto actualizada correctamente y usuario actualizado.'
                    ]);
                } else {
                    return response()->json([
                        'code' => 500,
                        'data' => 'Error al actualizar el usuario en la API externa.'
                    ], 500);
                }
            } else {
                return response()->json([
                    'code' => 404,
                    'data' => 'Foto no encontrada'
                ], 404);
            }
        } catch (\Throwable $th) {
            if (app()->environment('local')) {
                return response()->json(['error' => $th->getMessage()], 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidor'
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
                $tipoFotoId = $foto->fk_tipoFoto_id;
                $foto->delete();

                $usuarioId = $foto->fk_usuario_id;
                $dataToUpdate = [];

                if ($tipoFotoId == 1) {
                    $dataToUpdate = ['foto_perfil' => 'No hay foto'];
                } elseif ($tipoFotoId == 3) {
                    $dataToUpdate = ['foto_portada' => 'No hay foto'];
                }

                $response = Http::put("http://127.0.0.1:8000/api/usuario/actualizar/{$usuarioId}", $dataToUpdate);

                if ($response->successful()) {
                    return response()->json([
                        'code' => 200,
                        'data' => 'Foto eliminada correctamente y usuario actualizado.'
                    ]);
                } else {
                    return response()->json([
                        'code' => 500,
                        'data' => 'Error al actualizar el usuario en la API externa.'
                    ], 500);
                }
            } else {
                return response()->json([
                    'code' => 400,
                    'data' => 'La foto no se encuentra en nuestros registros'
                ]);
            }
        } catch (\Throwable $th) {
            if (app()->environment('local')) {
                return response()->json(['error' => $th->getMessage()], 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidor'
            ]);
        }
    }
}
