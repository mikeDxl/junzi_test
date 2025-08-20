<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentrodeCostos extends Model
{
    use HasFactory;

    protected $table = 'centro_de_costos';

    protected $fillable = [
        'centro_de_costos',
        'company_id',
        'presupuesto',
        'numeracion'
    ];

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
