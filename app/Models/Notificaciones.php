<?php

namespace App\Models;

use App\Mail\CorreoNotificaciones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


class Notificaciones extends Model
{
    use HasFactory;
    protected $table = 'notificaciones';

    protected $fillable = [
        'email',
        'tipo',
        'ruta',
        'fecha',
        'texto',
        'abierto',
        'archivado',
        'visto',
    ];

    protected static function booted()
    {
        static::created(function ($notificacion) {

            $url = 'http://junzi.mx:8080';

            // Recupera el usuario correspondiente al colaborador_id de la notificación
            $usuario = User::where('colaborador_id', $notificacion->email) // Suponiendo que 'email' en la notificación es el colaborador_id
                ->first(); // Obtén solo el primer usuario que coincida

            // Si se encuentra el usuario, obtener su nombre
            $nombreDestinatario = $usuario ? $usuario->name : 'Nombre no disponible';

            // Texto y ruta
            $texto = $notificacion->texto;
            $ruta = $url . $notificacion->ruta;
            $tipo = $notificacion->tipo;

            // Envía el correo a la dirección almacenada en la notificación
            /*
            Mail::to($notificacion->email) // Enviar al email que está en la notificación
                ->send(new CorreoNotificaciones($nombreDestinatario, $texto, $ruta, $tipo));
                */

        });
    }
}
