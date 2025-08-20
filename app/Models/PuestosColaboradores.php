<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestosColaboradores extends Model
{
    use HasFactory;

    protected $table = 'puestos_colaborador';

    protected $fillable = [
        'id_catalogo_puesto_id',
        'id_colaborador',
        'created_at',
        'updated_at',
    ];

    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'id_colaborador');
    }
}
