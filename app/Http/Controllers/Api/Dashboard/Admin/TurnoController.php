<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Admin\Turno\StoreRequest;
use App\Http\Requests\Dashboard\Admin\Turno\UpdateRequest;
use App\Http\Resources\turno\TurnoResource;
use App\Models\Turno;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function store(StoreRequest $request):JsonResponse{
        $request->validated();
        $turno = new Turno();
        $turno->name=$request->get('name');

        if($turno->save()){
            return response()->json(['message'=>'datos almacenados con exito', 'label'=>new TurnoResource($turno)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    public function index(): JsonResponse
    {
        return response()->json(TurnoResource::collection(Turno::all()));
    }
    
    public function show(Turno $turno): JsonResponse{
        return response()->json(new TurnoResource($turno));
    }

    public function update(UpdateRequest $request, Turno $turno):JsonResponse
    {
        $request->validated();
        $turno->name=$request->get('name');

        if($turno->save()){
            return response()->json(['message' => 'Datos actualizados con exito', 'label' => new TurnoResource($turno)]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    public function destroy(Turno $turno):JsonResponse
    {
        if($turno->delete()){
            return response()->json(['message' => 'Datos eliminados con exito']);
        }
        return response()->json(['message' => __('An error occurred while deleting data')], 500);
    }
}
