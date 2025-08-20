<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallazgoArchivos extends Model
{
    use HasFactory;

    protected $table = 'hallazgo_archivos';

    protected $fillable = [
        'id_auditoria',
        'id_hallazgo',
        'id_user',
        'comentario',
    ];

     public function hallazgo()
    {
        return $this->belongsTo(Hallazgos::class, 'id_hallazgo');
    }

     public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function auditoria()
    {
        return $this->belongsTo(Auditoria::class, 'id_auditoria');
    }
}
