<?php

namespace App\Http\Controllers;

use App\Models\PublicacionFotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicacionFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $publicacionFoto = PublicacionFotoModel::all();
            if($publicacionFoto->count()>0){
                return response()->json([
                    'code' => 200,
                    'data' => $publicacionFoto
                ], 200);
            }else{
                return response()->json([
                    'code' => 404,
                    'message' => 'No hay publicaciones con fotos.'
                ], 404);
            }
        }catch(\Throwable $th){
            if(app()->environment('local')){
                return response()->json($th->getMessage(), 500);
            }
            return response()->json([
                'code' => 500,
                'message' => 'Error inesperado.'
            ], 500);
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
        try{
            $validaciones = Validator::make($request->all(), [
                'fk_publicacion_id' => 'required|exists: publicacion, id',
                'fk_foto_id' => 'required|exists:foto, id'
            ]);
    
            if($validaciones->fails()){
                return response()->json([
                    'code' => 400,
                    'data' => $validaciones->messages()
                ], 400);
            }else{
                $publicacionFoto = PublicacionFotoModel::create($request->all());
                return response()->json([
                    'code' => 200,
                    'data' => $publicacionFoto
                ], 200);
    
            }
        }catch(\Throwable $th){
            if(app()->environment('local')){
                return response()->json($th->getMessage(), 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error inesperado.'
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
        // $validaciones = Validator::make($request->all(), [
        //     'fk_publicacion_id' => 'required_without:fk_foto_id|exists:publicacion, id',
        //     'fk_foto_id' => 'required_without:fk_publicacion_id|exists:foto, id'
        // ]);

        // if($validaciones->fails()){
        //     return response()->json([
        //         'code' => 400,
        //         'data' => $validaciones->messages()
        //     ], 400);
        // }else{
        //     $publicacionFoto = PublicacionFotoModel::find($id);
        //     if($publicacionFoto){
        //         $publicacionFoto->update($request->all());
        //         return response()->json([
        //             'code' => 200,
        //             'data' => 'Publicación con fotos actualizada correctamente'
        //         ], 200);
        //     }else{
        //         return response()->json([
        //             'code' => 404,
        //             'data' => 'Publicación con fotos no encontrada'
        //         ], 404);
        //     }
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
