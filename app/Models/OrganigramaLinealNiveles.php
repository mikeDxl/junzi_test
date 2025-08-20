<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganigramaLinealNiveles extends Model
{
    use HasFactory;

    protected $table = 'organigrama_lineal_niveles';

    protected $fillable = [
        'organigrama_id',
        'nivel',
        'colaborador_id',
        'jefe_directo_id',
        'jefe_directo_codigo',
        'puesto',
        'cc',
        'codigo',
        'company_id',
        'jerarquia'
    ];

    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'colaborador_id', 'id');
    }

    // Relación con el modelo Colaboradores (el jefe directo)
    public function jefe()
    {
        return $this->belongsTo(Colaboradores::class, 'jefe_directo_id', 'id');
    }

    // Relación con el modelo de Puestos
    public function puesto()
    {
        return $this->belongsTo(CatalogoPuestos::class, 'puesto', 'id');
    }

    // Relación con la tabla de Companies
    public function empresa()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }


}
