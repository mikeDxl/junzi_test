<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familiares extends Model
{
    use HasFactory;
    protected $table = 'familiares_colaborador';

    protected $fillable = [
        'company_id',
        'colaborador_id',
        'nombre',
        'relacion'
    ];

}
