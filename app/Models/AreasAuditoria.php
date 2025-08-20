<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasAuditoria extends Model
{
    use HasFactory;

    protected $table = 'areas_auditoria';

    protected $fillable = [
        'nombre',
        'clave',
        'es_planta',
        'trazabilidad',
    ];

    public function auditorias()
    {
        return $this->hasMany(Auditoria::class, 'area', 'clave');
    }

}
