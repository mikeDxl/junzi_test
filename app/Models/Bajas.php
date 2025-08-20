<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bajas extends Model
{
    use HasFactory;

    protected $table = 'bajas';

    protected $fillable = [
        'company_id',
        'colaborador_id',
        'area',
        'departamento_id',
        'puesto_id',
        'fecha_baja',
        'motivo',
        'vacante',
        'generada_por',
        'monto',
        'comprobante',
        'estatus'
    ];

    public function vacante()
    {
        return $this->belongsTo(Vacantes::class, 'vacante');
    }
}
