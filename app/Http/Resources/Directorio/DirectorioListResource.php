<?php

namespace App\Http\Resources\Directorio;

use App\Http\Resources\Empleado\EmpleadoResource;
use App\Http\Resources\Ticket\TicketManageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectorioListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $directorio =$this;

        return[
            'id'=>$directorio->id,
            'empleado'=>new EmpleadoResource($directorio->empleado),
            'ticket'=>new TicketManageResource($directorio->ticket),
            'fecha_asignacion'=>$directorio->fecha_asignacion,
            'fecha_baja'=>$directorio->fecha_baja
        ];
    }
}
