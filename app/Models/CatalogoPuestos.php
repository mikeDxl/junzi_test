<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoPuestos extends Model
{
    use HasFactory;

    protected $table = 'catalogo_puestos';

    protected $fillable = [
        'puesto',
        'tipo',
        'perfil',
        'created_at',
        'updated_at',
    ];

    public function colaboradores()
    {
        return $this->belongsToMany(Colaboradores::class, 'puestos_colaborador', 'id_catalogo_puesto_id', 'id_colaborador');
    }

    
    public function puestosCC()
    {
        return $this->hasMany(PuestosCC::class, 'id_catalogo_puesto_id');
    }
    
}
