<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPatronal extends Model
{
    use HasFactory;
    protected $table = 'registro_patronal';

    protected $fillable = [
        'cidregistropatronal',
        'company_id',
        'registro_patronal',
    ];

}
