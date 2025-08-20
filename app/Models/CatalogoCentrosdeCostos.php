<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoCentrosdeCostos extends Model
{
    use HasFactory;

    protected $table = 'catalogo_centros_de_costos';

    protected $fillable = [
        'centro_de_costo',
        'created_at',
        'updated_at',
    ];

  

    public function puestos()
    {
        return $this->hasMany(PuestosCC::class, 'id_catalogo_centro_de_costos_id');
    }

    public function colaboradores()
    {
        return $this->hasManyThrough(
            Colaboradores::class,
            ColaboradoresCC::class,
            'id_catalogo_centro_de_costos_id', // Clave foránea en ColaboradoresCC
            'id', // Clave primaria en Colaborador
            'id', // Clave primaria en CatalogoCentrosdeCostos
            'colaborador_id' // Clave foránea en ColaboradoresCC
        );
    }
}
