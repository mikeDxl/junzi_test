<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procesos extends Model
{
    use HasFactory;

    protected $table = 'procesos';

    protected $fillable = [
          'vacante_id',
          'candidato_id',
          'estatus',
          'habilitado',
    ];
}
