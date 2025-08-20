<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;
    protected $table = 'ubicaciones';

    protected $fillable = [
        'id',
        'ubicacion',
        'company_id',
        'abreviatura',
    ];

    public function colaboradores()
    {
        return $this->hasMany(Colaboradores::class, 'ubicaciones', 'ubicacion')
                    ->where('estatus', 'activo'); // Solo colaboradores activos
    }
}
