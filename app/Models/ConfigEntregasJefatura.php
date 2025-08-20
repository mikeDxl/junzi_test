<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigEntregasJefatura extends Model
{
    use HasFactory;

    protected $table = 'config_entregas_jefatura';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = ['reporte', 'periodo'];
}
