<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioHallazgos extends Model
{
    use HasFactory;

    protected $table = 'comentario_hallazgos';

    protected $fillable = [
        'comentario',
        'id_hallazgo',
        'id_user',
    ];

     public function hallazgo()
    {
        return $this->belongsTo(Hallazgos::class, 'id_hallazgo');
    }

     public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
