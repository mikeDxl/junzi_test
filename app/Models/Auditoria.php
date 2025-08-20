<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auditoria extends Model
{
    use HasFactory, SoftDeletes; 

    protected $table = 'auditorias';


    protected $fillable = [
        'tipo',
        'anio',
        'area',
        'ubicacion',
        'fecha_alta',
        'folio',
        'estatus',
        'cc',
    ];

    public function hallazgos()
    {
        return $this->hasMany(Hallazgos::class);
    }

    public function colaboradores()
    {
        return $this->belongsToMany(Colaborador::class, 'auditoria_colaborador', 'auditoria_id', 'colaborador_id');
    }

    public function hallazgosPendientes()
    {
        return $this->hasMany(Hallazgos::class)->where('estatus', 'Pendiente');
    }

    public function hallazgosCerrados()
    {
        return $this->hasMany(Hallazgos::class)->where('estatus', 'Cerrado');
    }

    public function areaAuditoria()
    {
        return $this->belongsTo(AreasAuditoria::class, 'area', 'clave');
    }

    public function archivo()
    {
        return $this->hasMany(HallazgoArchivos::class);
    }

}
