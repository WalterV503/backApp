<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Models\TipoFotoModel;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TipoFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $tipoFoto = TipoFotoModel::all();
            if($tipoFoto->count()>0){
                return response()->json([
                    'code' => 200,
                    'data' => $tipoFoto
                ], 200);
            }else{
                return response()->json([
                    'code' => 204,
                    'data' => 'No hay registros de Tipos de Foto'
                ], 204);
            }
        }catch(\Throwable $th){
            if(app()->environment('local')){
                return response()->json($th->getMessage(), 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidor'
            ]);
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
                'Nombre_Tipo_Foto' => 'required|string|max:255'
            ]);
            if($validaciones->fails()){
                return response()->json([
                    'code' => 400,
                    'data' => $validaciones->messages()
                ], 400);
            }else{
                $tipoFoto = TipoFotoModel::create($request->all());

                return response()->json([
                    'code' => 200,
                    'data' => 'Producto creado exitosamente'
                ], 200);
            }
        }catch(\Throwable $th){
            if(app()->environment('local')){
                return response()->json($th->getMessage(), 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidor'
            ]);
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
        try{
            $validaciones = Validator::make($request->all(), [
                'Nombre_Tipo_Foto' => 'required|string|max:255'
            ]);

            if($validaciones->fails()){
                return response()->json([
                    'code' => 400,
                    'data' => $validaciones->messages()
                ]);
            }else{
                $tipoFoto = TipoFotoModel::find($id);
                if($tipoFoto){
                    $tipoFoto->update($request->all());
                    return response()->json([
                        'code' => 200,
                        'data' => 'Tipo de foto actualizada correctamente'
                    ]);
                    
                }else{
                    return response()->json([
                        'code' => 404,
                        'data' => 'Tipo foto no encontrado'
                    ], 404);
                }
            }
        }catch(\Throwable $th){
            if(app()->environment('local')){
                return response()->json($th->getMessage(), 500);
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
        try{
            $tipoFoto = TipoFotoModel::find($id);
        if($tipoFoto){
            $tipoFoto->delete();
            return response()->json([
                'code' => 200,
                'data' => 'Tipo de foto eliminado correctamente'
            ]);
        }else{
            return response()->json([
                'code' => 400,
                'data' => 'Tipo de foto no encontrada'
            ]);
        }
            }catch(\Throwable $th){
                if(app()->environment('local')){
                    return response()->json($th->getMessage(), 500);
                }
                return response()->json([
                    'code' => 500,
                    'data' => 'Error en el servidor'
                ]);
            }
    }

    public function search($id){
        try{
            $tipoFoto = TipoFotoModel::find($id);

            if($tipoFoto){
                return response()->json([
                    'code' => 200,
                    'data' => $tipoFoto
                ]);
            }else{
                return response()->json([
                    'code' => 400,
                    'data' => 'Tipo de foto no ha sido encontrado'
                ]);
            }
        }catch(\Throwable $th){
            if(app()->environment('local')){
                return response()->json($th->getMessage(), 500);
            }
            return response()->json([
                'code' => 500,
                'data' => 'Error en el servidos'
            ]);
        }
    }
}
