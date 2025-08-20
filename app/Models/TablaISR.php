<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TablaISR extends Model
{
    use HasFactory;
    protected $table = 'tabla_isr';

    protected $fillable = [
        'limite_inferior',
        'limite_superior',
        'cuota_fija',
        'porcentaje',
        'anio',
        'periodo',
    ];

    public static function buscarLimiteInferior($baseGravable, $anio , $periodo)
    {
        return static::where('anio', $anio)
            ->where('limite_inferior', '<=', $baseGravable)
            ->where('limite_superior', '>=', $baseGravable)
            ->value('limite_inferior');
    }

    public static function buscarPorcentaje($baseGravable, $anio , $periodo)
    {
        return static::where('anio', $anio)
            ->where('limite_inferior', '<=', $baseGravable)
            ->where('limite_superior', '>=', $baseGravable)
            ->value('porcentaje');
    }


    public static function buscarCuotaFija($baseGravable, $anio , $periodo)
    {
        return static::where('anio', $anio)
            ->where('limite_inferior', '<=', $baseGravable)
            ->where('limite_superior', '>=', $baseGravable)
            ->value('cuota_fija');
    }

}
