<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Directorio extends Model
{
    use HasFactory,Filterable;


    protected $cast=[

        'empleado_id'=>'integer',
        'ticket_id'=>'integer'
    ];


    public function empleado():BelongsTo
    {
        return $this->belongsTo(Empleado::class);

    }

    public function ticket():BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
