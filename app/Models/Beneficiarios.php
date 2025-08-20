<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiarios extends Model
{
    use HasFactory;
    protected $table = 'beneficiarios_colaborador';


    protected $fillable = [
        'company_id',
        'colaborador_id',
        'nombre',
        'telefono'
    ];

}
