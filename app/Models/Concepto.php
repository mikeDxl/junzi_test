<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;

    protected $table = 'conceptos';


    protected $fillable = [
        'company_id',
        'idconcepto',
        'numeroconcepto',
        'tipoconcepto',
        'descripcion',
        'especie',
        'automaticoglobal',
        'automaticoliquidacion',
        'imprimir',
        'articulo86',
        'leyendaimporte1',
        'leyendaimporte2',
        'leyendaimporte3',
        'leyendaimporte4',
        'cuentacw',
        'tipomovtocw',
        'contracuentacw',
        'contabcuentacw',
        'contabcontracuentacw',
        'leyendavalor',
        'formulaimportetotal',
        'formulaimporte1',
        'formulaimporte2',
        'formulaimporte3',
        'formulaimporte4',
        'FormulaValor',
        'CuentaGravado',
        'CuentaExentoDeduc',
        'CuentaExentoNoDeduc',
        'ClaveAgrupadoraSAT',
        'MetodoDePago',
        'TipoClaveSAT',
        'TipoHoras',
    ];
}
