<?php 

namespace App\Filters;

use App\Models\Empleado;
use App\Models\Ticket;
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

    public function turnoEmpleado($turnoEmpleado):DirectorioFilter
    {
        $turnoEmpleadoList=Empleado::where('turno_id',$turnoEmpleado)->pluck('id');
        return $this->whereIn('empleado_id', $turnoEmpleadoList);
    }

    public function NsModelo($NsModelo):DirectorioFilter
    {
        $NsModeloList=Ticket::where('modelo', 'LIKE', '%'.$NsModelo.'%')
                               ->orWhere('numero_serie', 'LIKE', '%'.$NsModelo.'%')
                               ->pluck('id');
        
        return $this->whereIn('ticket_id', $NsModeloList);

        }

        public function oficinasEquipo($oficinaEquipo):DirectorioFilter
        {
            $oficinaEquipoList=Ticket::where('oficina_id',$oficinaEquipo)->pluck('id');
            return $this->whereIn('empleado_id',$oficinaEquipoList);
        }
}
