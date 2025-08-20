<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartamentosCC extends Model
{
    use HasFactory;
    protected $table = 'departamento_centros_de_costos';
    protected $filable = ['id_catalogo_departamento_id' , 'id_catalogo_centro_de_costos_id'];

    public function catalogoDepartamentos()
    {
        return $this->belongsTo(CatalogoDepartamentos::class, 'id_catalogo_departamento_id');
    }

}
