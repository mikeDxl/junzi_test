<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogosdeTiposdeBasedePago extends Model
{
    use HasFactory;
    protected $table = 'catalogo_de_tipos_de_base_de_pago';

    protected $fillable = [
        'tipo',
        'nomipaq']
        ;

}
