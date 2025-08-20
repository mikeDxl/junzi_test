<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table='mensajes';

    protected $fillable = [
        'contenido', // Asegúrate de que este campo coincida con el que has definido en la migración
        'grupo_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Relación con Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
