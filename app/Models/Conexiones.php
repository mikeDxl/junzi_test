<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conexiones extends Model
{
    use HasFactory;

    protected $table = 'conexiones';


    protected $fillable = [
        'driver', 'port', 'database', 'password', 'user',
        'host', 'name', 'company_id',
    ];

    // Relación pertenece a una compañía
    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id');
    }
}
