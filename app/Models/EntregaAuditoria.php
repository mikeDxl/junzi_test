<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EntregaAuditoria extends Model
{
    use HasFactory;

    protected $table = 'entregas_auditoria';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_reporte', 'fecha_de_entrega', 'responsable', 'jefe_directo',
        'entregado', 'dias_retraso', 'archivo_adjunto','estatus','fecha_habilitada','fecha_completada'
    ];

    // Definir la relación con ConfigEntregasAuditoria (si es necesario)
    public function configReporte()
    {
        return $this->belongsTo(ConfigEntregasAuditoria::class, 'id_reporte');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->fecha_completada) {
                // Calcular la diferencia en días entre fecha_completada y fecha_de_entrega
                $fechaEntrega = Carbon::parse($model->fecha_de_entrega);
                $fechaCompletada = Carbon::parse($model->fecha_completada);

                // Resta la diferencia en días
                $diasRetraso = $fechaCompletada->diffInDays($fechaEntrega, false);  // false para que pueda ser negativo

                // Si es negativo, lo dejamos en 0
                $model->dias_retraso = max(0, $diasRetraso);
            }
        });
    }
}
