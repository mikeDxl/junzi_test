<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incapacidad extends Model
{
    use HasFactory;

    protected $table = 'incapacidades';

    protected $fillable = [
        'company_id',
        'colaborador_id',
        'jefe_directo_id',
        'cc',
        'dias',
        'apartir',
        'expedido',
        'estatus',
        'autorizo',
        'comentarios',
        'otro',
        'anio',
        'archivo',
    ];

    // Relaciones
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class);
    }

    public function jefeDirecto()
    {
        return $this->belongsTo(Colaboradores::class, 'jefe_directo_id');
    }

    public function autorizadoPor()
    {
        return $this->belongsTo(User::class, 'autorizo');
    }

    // Métodos adicionales y mutadores si es necesario
}
