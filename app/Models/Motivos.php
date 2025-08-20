<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivos extends Model
{
    use HasFactory;

    protected $table = 'motivos_rechazo';

    protected $fillable = [
        'candidato_id',
        'vacante_id',
        'proceso_id',
        'motivo',
        'usuario',
    ];
}
