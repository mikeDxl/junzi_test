<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoIncidencia extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'conceptos_incidencias';

    // Los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'id_company',
        'id_concepto',
    ];

    /**
     * Relaciones: Puedes agregar aquí relaciones según tus necesidades.
     */

    // Relación con la tabla Company (si existe)
    public function company()
    {
        return $this->belongsTo(Company::class, 'id_company');
    }

    // Relación con la tabla Concepto (si existe)
    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'id_concepto');
    }
}
