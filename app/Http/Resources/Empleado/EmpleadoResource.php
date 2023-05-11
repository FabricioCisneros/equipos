<?php

namespace App\Http\Resources\Empleado;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpleadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $empleado=$this;
        return[
            'id'=>$empleado->id,
            'name'=>$empleado->name,
            'apellidos'=>$empleado->apellidos,
            'email'=>$empleado->email,
            'telefono'=>$empleado->telefono,
            'oficina_id'=>$empleado->oficina_id,
            'turno_id'=>$empleado->turno_id,
        ];
    }
}
