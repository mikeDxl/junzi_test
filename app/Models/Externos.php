<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Externos extends Model
{
    use HasFactory;

    protected $table = 'externos';

    protected $fillable = [
        'area',
        'company_id',
        'empresa',
        'giro',
        'tipo',
        'presupuesto',
        'cantidad',
        'comentarios',
        'estatus',
        'rfc',
        'jefe',
        'ingreso',
    ];
}
