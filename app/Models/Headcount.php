<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headcount extends Model
{
    use HasFactory;

    protected $table = 'headcount'; // Especifica el nombre de la tabla

    protected $fillable = [
        'mes',
        'anio',
        'company_id',
        'activos',
        'vacantes',
        'desvinculados',
    ];
}
