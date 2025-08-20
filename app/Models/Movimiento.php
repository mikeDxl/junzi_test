<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Headcount',
        'Empresa',
        'TipoEmpresa',
        'OrgMatricial',
        'RazonSocial',
        'FechaAlta',
        'EmpleadoCod',
        'EmpleadoNombreLargo',
        'DeptoNombre',
        'PuestoNombre',
        'ConceptoBandera',
        'Ubicacion',
        'EmpleadoEstatus',
        'FechaBaja',
        'Ejercicio',
        'PeriodoInicio',
        'PeriodoFin',
        'PeriodoTipoNombre',
        'PeriodoNumero',
        'Periodo',
        'PeriodoNombre',
        'ConceptoNombre',
        'ConceptoTipo',
        'Importe',
        'TipoDato',
        'Agrupador',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'FechaAlta' => 'date',
        'FechaBaja' => 'date',
        'PeriodoInicio' => 'date',
        'PeriodoFin' => 'date',
    ];
}
