<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColaboradoresEmpresa extends Model
{
    use HasFactory;

    protected $table = 'colaboradores_empresa';

    protected $fillable = [
        'colaborador_id',
        'company_id',
    ];

    // Puedes agregar relaciones y otros métodos aquí según sea necesario

    // Relación con el modelo Colaboradores
    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'colaborador_id');
    }

    // Relación con el modelo Companies
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
