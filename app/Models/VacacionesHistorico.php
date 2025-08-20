<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacacionesHistorico extends Model
{
    use HasFactory;

    protected $table = 'vacaciones_historico';

    protected $fillable = [
        'colaborador_id',
        'anio',
        'tomadas'
    ];
}
