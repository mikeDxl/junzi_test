<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColaboradoresCC extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'colaboradores_centros_de_costos';

    /**
     * Campos asignables de forma masiva.
     *
     * @var array
     */
    protected $fillable = [
        'colaborador_id',
        'id_catalogo_centro_de_costos_id',
    ];

   
    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'colaborador_id');
    }

    
    public function catalogoCentroDeCostos()
    {
        return $this->belongsTo(CatalogoCentrodeCostos::class, 'id_catalogo_centro_de_costos_id');
    }

    public function puestosColaboradores()
    {
        return $this->hasMany(PuestosColaboradores::class, 'colaborador_id');
    }

    
}
