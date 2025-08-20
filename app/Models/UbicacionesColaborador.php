<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionesColaborador extends Model
{
    use HasFactory;
    protected $table = 'ubicaciones_colaborador';

    protected $fillable = [
        'id_ubicacion',
        'id_colaborador',
    ];
}
