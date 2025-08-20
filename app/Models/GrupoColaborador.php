<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoColaborador extends Model
{
    use HasFactory;

    protected $table = 'grupos_colaboradores'; // Definir el nombre de la tabla

    protected $fillable = [
        'grupo_id',
        'colaborador_id',
    ];

    // Relación con Grupo
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }

    // Relación con Colaborador
    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_id');
    }
}
