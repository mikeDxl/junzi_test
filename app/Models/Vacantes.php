<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacantes extends Model
{
    use HasFactory;
    protected $table = 'vacantes';

    protected $fillable = [
        'company_id',
        'departamento_id',
        'puesto_id',
        'solicitadas',
        'completadas',
        'codigo',
        'prioridad',
        'estatus',
        'jefe',
        'area',
        'fecha',
        'area_id',
        'proceso'
    ];

    public function altas()
    {
        return $this->hasMany(Altas::class, 'id_vacante');
    }




    public function scopeVisibleByRole($query)
    {
        $user = auth()->user();

        // Si el usuario es un Colaborador, no puede ver ninguna vacante.
        if ($user->rol === 'Colaborador') {
            return $query->whereNull('id'); // Retorna un query vacío
        }

        // Si el usuario es Jefatura, solo puede ver las vacantes de las que es jefe.
        if ($user->rol === 'Jefatura') {
            return $query->where('jefe', $user->colaborador_id);
        }

        // Los demás roles pueden ver todas las vacantes.
        return $query;
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }

    public function departamento()
    {
        return $this->belongsTo(CatalogoDepartamentos::class, 'departamento_id');
    }

    public function puesto()
    {
        return $this->belongsTo(CatalogoPuestos::class, 'puesto_id');
    }

    public function jefedirecto()
    {
        return $this->belongsTo(Colaboradores::class, 'jefe');
    }


    public function cc()
    {
        return $this->belongsTo(CatalogoCentrosdeCostos::class, 'area_id');
    }



}
