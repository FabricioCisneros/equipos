<?php

namespace App\Http\Resources\Oficina;

use Illuminate\Http\Resources\Json\JsonResource;

class OficinaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $oficina = $this;
        return [
            'id' => $oficina->id,
            'name' => $oficina->name,
            'estado'=>$oficina->estado,
            'created_at' => $oficina->created_at->toISOString()
        ];
    }
}
