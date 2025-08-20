<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';


    protected $fillable = [
        'id_evaluador',
        'id_colaborador',
        'pregunta1',
        'pregunta2',
        'pregunta3',
        'pregunta4',
        'pregunta5',
        'pregunta6',
    ];

    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'id_colaborador');
    }

    public function evaluador()
    {
        return $this->belongsTo(Colaboradores::class, 'id_evaluador');
    }
}
