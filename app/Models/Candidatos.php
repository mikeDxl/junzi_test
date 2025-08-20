<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatos extends Model
{
    use HasFactory;

    protected $table = 'candidatos';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'edad',
        'cv',
        'fuente',
        'comentarios',
        'estatus',
        'email',
        'telefono',
    ];
}
