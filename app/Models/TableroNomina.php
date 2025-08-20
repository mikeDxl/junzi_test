<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableroNomina extends Model
{
    use HasFactory;

    protected $table = 'tablero';

    protected $fillable = [
        'headcount',
        'empresa',
        'tipo_empresa',
        'org_matricial',
        'razon_social',
        'fecha_alta',
        'empleado_cod',
        'empleado_nombre_largo',
        'depto_nombre',
        'puesto_nombre',
        'concepto_bandera',
        'ubicacion',
        'empleado_estatus',
        'fecha_baja',
        'ejercicio',
        'periodo_inicio',
        'periodo_fin',
        'periodo_tipo_nombre',
        'periodo_numero',
        'periodo',
        'periodo_nombre',
        'concepto_nombre',
        'concepto_tipo',
        'importe',
        'tipo_dato',
        'agrupador'
    ];


    public function empresa()
    {
        return $this->belongsTo(Companies::class, 'empresa', 'id');
    }
}
