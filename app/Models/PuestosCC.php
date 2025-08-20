<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestosCC extends Model
{
    use HasFactory;


    protected $table = 'puestos_centros_de_costos';


    protected $fillable = [
        'id_catalogo_puestos_id',
        'id_catalogo_centro_de_costos_id',
    ];


    public $timestamps = true;


    public function catalogoPuesto()
    {
        return $this->belongsTo(CatalogoPuestos::class, 'id_catalogo_puestos_id');
    }


    public function catalogoCentroDeCostos()
    {
        return $this->belongsTo(CatalogoCentroDeCostos::class, 'id_catalogo_centro_de_costos_id');
    }

    public function colaboradores()
    {
        return $this->belongsToMany(Colaboradores::class, 'puestos_colaborador', 'id_catalogo_puestos_id', 'id_colaborador');
    }


}
