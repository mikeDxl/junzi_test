<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigHallazgos extends Model
{
    use HasFactory;

    protected $table = 'titulos_hallazgos';

    protected $fillable = [
        'area',
        'titulo',
        'subtitulo',
        'tipo',
        'obligatorio'
    ];


    public function subtitulos()
    {
        return $this->hasMany(ConfigHallazgos::class, 'titulo');
    }

    // Relación con los subtítulos (si quieres que los subtítulos estén relacionados con los títulos)
    public function titulos()
    {
        return $this->hasMany(ConfigHallazgos::class, 'area');
    }
}
