<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacacionesPendientes extends Model
{
    use HasFactory;

    protected $table = 'vacaciones_pendientes';

    protected $fillable = [
        'company_id', //comapny
        'colaborador_id', //colaborador
        'fecha_alta', //colaborador
        'anteriores', //0 - J
        'actuales', //0 - K
    ];
}
