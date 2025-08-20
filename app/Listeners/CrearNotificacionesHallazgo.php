<?php

namespace App\Listeners;

use App\Events\HallazgoGuardado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notificaciones;

class CrearNotificacionesHallazgo
{
    public function handle(HallazgoGuardado $event)
    {
        $ruta = 'hallazgo/' . $event->hallazgo->id . '/edit';
        $texto = 'Hallazgo ' . $event->accion . ': ' . $event->hallazgo->hallazgo;

        $usuarios = collect($event->usuarios)
            ->merge($event->usuariosAuditoria)
            ->unique('email')
            ->filter(fn($usuario) => !empty($usuario->email));

        foreach ($usuarios as $usuario) {
            Notificaciones::create([
                'email' => $usuario->email,
                'tipo' => 'success',
                'ruta' => $ruta,
                'fecha' => now(),
                'texto' => $texto,
                'abierto' => '0',
            ]);
        }
    }
}
