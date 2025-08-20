<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualizacion extends Model
{
    use HasFactory;

    protected $table = 'actualizaciones';

    protected $fillable = ['fecha', 'database', 'id_company'];

    public $timestamps = false;
}
