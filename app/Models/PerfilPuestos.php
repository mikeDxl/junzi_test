<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilPuestos extends Model
{
    use HasFactory;

    protected $table = 'puestos';

    protected $fillable = [
        'idpuesto',
        'numeropuesto',
        'company_id',
        'departamento_id',
        'puesto',
        'presupuesto',
        'jerarquia',
        'padre',
        'estatus',
        'perfil',
        'codigo'
    ];

}
