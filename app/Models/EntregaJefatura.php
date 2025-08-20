<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaJefatura extends Model
{
    use HasFactory;

    protected $table = 'entregas_jefatura';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_reporte', 'fecha_de_entrega', 'responsable', 'jefe_directo',
        'entregado', 'dias_retraso', 'archivo_adjunto','estatus','fecha_habilitada','fecha_completada'
    ];

    // Definir la relación con ConfigEntregasJefatura (si es necesario)
    public function configReporte()
    {
        return $this->belongsTo(ConfigEntregasJefatura::class, 'id_reporte');
    }
}
