<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desvinculados extends Model
{
  use HasFactory;

  protected $table = 'desvinculados';

  protected $fillable = [
      'company_id',
      'idempleado',
      'fecha_baja',
      'curp',
      'causabaja',
  ];
}
