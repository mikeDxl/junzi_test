<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hallazgos extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'hallazgos';

    protected $fillable = [
        'auditoria_id',
        'responsable',
        'jefe',
        'fecha_presentacion',
        'fecha_limite',
        'hallazgo',
        'estatus',
        'evidencia',
        'comentarios',
        'fecha_cierre',
        'fecha_compromiso',
        'fecha_identificacion',
        'tipo',
        'comentarios_colaborador',
        'evidencia_colaborador',
        'fecha_colaborador',
        'sugerencia',
        'titulo',
        'plan_de_accion',
        'respuestaid',
        'respuesta',
        'criticidad',
    ];

    public function titysubtit()
    {
        return $this->belongsTo(ConfigHallazgos::class, 'titulo');
    }

    public function auditoria()
    {
        return $this->belongsTo(Auditoria::class, 'auditoria_id');
    }

    // Relación personalizada para 'responsable'
    public function responsables()
    {
        $ids = $this->getResponsableIds();
        return Colaboradores::whereIn('id', $ids)->get();
    }

    // Relación personalizada para 'jefe'
    public function jefes()
    {
        $ids = $this->getJefeIds();
        return Colaboradores::whereIn('id', $ids)->get();
    }

    // Obtener IDs de 'responsable'
    private function getResponsableIds()
    {
        return array_filter(array_map('trim', explode(',', $this->responsable)));
    }

    // Obtener IDs de 'jefe'
    private function getJefeIds()
    {
        return array_filter(array_map('trim', explode(',', $this->jefe)));
    }

    public function area()
    {
        return $this->hasOneThrough(
            AreasAuditoria::class,
            Auditoria::class,
            'id',        // Llave foránea en Auditoria que conecta con Hallazgos (auditoria_id)
            'clave',     // Llave foránea en AreasAuditoria que conecta con Auditoria (area)
            'auditoria_id', // Llave local en Hallazgos
            'area'       // Llave local en Auditoria
        );
    }
    public function comentario()
    {
        return $this->hasMany(ComentarioHallazgos::class);
    }

    public function archivo()
    {
        return $this->hasMany(HallazgoArchivos::class);
    }
}
