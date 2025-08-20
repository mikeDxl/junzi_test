<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $table = 'periodos';


    protected $fillable = [
        'company_id',
        'idperiodo',
        'idtipoperiodo',
        'numeroperiodo',
        'ejercicio',
        'mes',
        'diasdepago',
        'septimos',
        'interfazcheqpaqw',
        'modificacionneto',
        'calculado',
        'afectado',
        'fechainicio',
        'fechafin',
        'inicioejercicio',
        'iniciomes',
        'finmes',
        'finejercicio',
        'cfinbimestreimss',
        'ciniciobimestreimss',
        'fechaPago',
    ];
}
