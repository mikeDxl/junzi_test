<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasVacaciones extends Model
{
    use HasFactory;

    protected $table = 'dias_vacaciones';
    protected $fillable = [
        'anio',
        'anio_laborado',
        'dias_vacaciones',
    ];
}
