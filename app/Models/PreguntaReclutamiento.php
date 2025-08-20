<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaReclutamiento extends Model
{
    use HasFactory;
    protected $table = 'preguntas_reclutamiento';
    protected $fillable = [
        'company_id',
        'id_vacante',
        'id_candidato',
        'etapa',
        'perfil',
        'pregunta',
        'valoracion',
    ];

    
}
