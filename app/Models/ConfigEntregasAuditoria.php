<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigEntregasAuditoria extends Model
{
    use HasFactory;

    protected $table = 'config_entregas_auditoria';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = ['reporte', 'periodo'];
}
