<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'user_id',
        'nombre',
        'rfc',
        'razon_social',
        'calle',
        'colonia',
        'codigo_postal',
        'municipio',
        'ciudad',
        'estado',
        'pais',
        'estatus',
        'imss',
        'abreviatura',
    ];

    public function centrodeCostos()
    {
        return $this->hasMany(CentrodeCostos::class, 'company_id');
    }

    public function colaboradores()
    {
        return $this->hasMany(Colaboradores::class, 'company_id');
    }

    // Accesor para contar los empleados activos
    public function getEmpleadosActivosAttribute()
    {
        return $this->colaboradores()->where('estatus', 'activo')->count();
    }

    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class, 'company_id');
    }
    public function conceptosIncidencias()
    {
        return $this->hasMany(ConceptoIncidencia::class, 'id_company');
    }


    // Puedes agregar relaciones, métodos, y otros aquí según sea necesario

}
