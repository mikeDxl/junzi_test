<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoRH extends Model
{
    use HasFactory;

    protected $table = 'proceso_reclutamiento';

    protected $fillable = [
        'company_id',
        'vacante_id',
        'candidato_id',
        'curriculum',
        'entrevista1_fecha',
        'entrevista1_hora',
        'entrevista2_fecha',
        'entrevista2_hora',
        'referencia_nombre1',
        'referencia_telefono1',
        'referencia_empresa1',
        'referencia_nombre2',
        'referencia_telefono2',
        'referencia_empresa2',
        'referencia_nombre3',
        'referencia_telefono3',
        'referencia_empresa3',
        'examen',
        'documento1',
        'documento2',
        'documento3',
        'documento4',
        'documento5',
        'comentarios',
        'current',
        'entrevista1_hasta',
        'entrevista1_desde',
        'estatus_entrevista',
        'fotoexamen',
        'estatus_documento1',
        'estatus_documento2',
        'estatus_documento3',
        'estatus_documento4',
        'estatus_documento5',
        'orden',
        'estatus_proceso',
        'fecha_jefatura',
        'fecha_nomina',
        'fecha_reclutamiento',
        'comentariodoc1',
        'comentariodoc2',
        'comentariodoc3',
        'comentariodoc4',
        'comentariodoc5',
        'prioridad',
        'habilitado',
        'rechazado_por',
    ];

    public function vacante()
    {
        return $this->belongsTo(Vacantes::class, 'vacante_id');
    }
}
