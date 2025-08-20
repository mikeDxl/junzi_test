<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table='grupos';

    protected $fillable = [
        'nombre',
    ];

    // Relación con GrupoColaborador
    public function colaboradores()
    {
        return $this->belongsToMany(Colaboradores::class, 'grupos_colaboradores', 'grupo_id', 'colaborador_id');
    }
    

    // Relación con Mensaje
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'grupo_id');
    }
}
