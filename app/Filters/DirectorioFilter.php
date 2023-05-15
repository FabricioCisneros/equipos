<?php 

namespace App\Filters;

use App\Models\Empleado;
use EloquentFilter\ModelFilter;

class DirectorioFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function searchEmpleado($searchEmpleado):DirectorioFilter
    {
        $empleadoId=Empleado::where('name', 'LIKE', '%'.$searchEmpleado.'%')
                            ->orWhere('apellidos', 'LIKE', '%'.$searchEmpleado.'%')
                            ->pluck('id');

        return $this->whereIn('empleado_id', $empleadoId);
    }

    public function correo($correo):DirectorioFilter
    {
        $correoId=Empleado::where('email', 'LIKE', '%'.$correo.'%')
                            ->pluck('id');

        return $this->whereIn('empleado_id',$correoId);
    }

    public function oficinasEmpleado($oficinasEmpleado):DirectorioFilter
    {
        $oficinaEmpleado=Empleado::where('oficina_id',$oficinasEmpleado)->pluck('id');
        return $this->whereIn('empleado_id',$oficinaEmpleado);
    }
}
