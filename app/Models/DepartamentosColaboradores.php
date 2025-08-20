<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartamentosColaboradores extends Model
{
    use HasFactory;

    protected $table = 'departamento_colaboradores';

    protected $fillable = [
        'id_catalogo_departamento_id',
        'colaborador_id',
        'created_at',
        'updated_at',
    ];
}
