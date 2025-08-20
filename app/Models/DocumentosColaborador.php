<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosColaborador extends Model
{
    use HasFactory;

    protected $table = 'documentos_colaboradores';

    // Asegúrate de incluir todos los campos que quieras asignar masivamente
    protected $fillable = ['colaborador_id', 'tipo', 'ruta'];
}
