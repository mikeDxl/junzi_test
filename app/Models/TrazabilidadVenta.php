<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrazabilidadVenta extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'trazabilidad_ventas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'empresa',
        'planta',
        'nota_de_entrega',
        'factura',
        'carta_porte',
        'complemento_carta',
        'anio',
        'mes',
    ];

    // Campos que no pueden ser asignados masivamente
    protected $guarded = ['id'];

    // Si deseas personalizar los timestamps
    public $timestamps = true;
}
