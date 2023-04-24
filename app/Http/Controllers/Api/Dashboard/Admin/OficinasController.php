<?php

namespace App\Http\Controllers\Api\Dashboard\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Oficina\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Oficina\UpdateRequest;
use App\Http\Resources\Oficina\OficinaResource;
use App\Models\Oficina;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class OficinasController extends Controller
{
 
    
    public function store(StoreRequest $request): JsonResponse
    {
        $request->validated();
        $oficina = new Oficina();
        $oficina->name = $request->get('name');
        $oficina->estado=$request->get('estado');
        if ($oficina->save()) {
            return response()->json(['message' => 'Data saved correctly', 'label' => new OficinaResource($oficina)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    public function index(): JsonResponse
    {
        return response()->json(OficinaResource::collection(Oficina::all()));
    }
    public function show(Oficina $oficina): JsonResponse
    {
        return response()->json(new OficinaResource($oficina));
    }

    public function update(UpdateRequest $request, Oficina $oficina): JsonResponse
    {
        $request->validated();
        $oficina->name = $request->get('name');
        $oficina->estado=$request->get('estado');
        if ($oficina->save()) {
            return response()->json(['message' => 'Datos actualizados con exito', 'label' => new OficinaResource($oficina)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
    public function destroy(Oficina $oficina): JsonResponse
    {
       
        if ($oficina->delete()) {
            return response()->json(['message' => 'Data deleted successfully']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }
}
