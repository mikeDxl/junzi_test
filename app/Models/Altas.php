<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Altas extends Model
{
    use HasFactory;

    protected $table = 'altas';


    protected $fillable = [
        'candidato_id',
        'company_id',
        'fecha_alta',
        'estatus',
        'jefe_directo_id',
        'centro_de_costos',
        'motivo',
        'id_puesto',
        'id_vacante',
        'codigo',
    ];

    public function vacante()
    {
        return $this->belongsTo(Vacantes::class, 'id_vacante');
    }
}
