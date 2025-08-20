<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Hallazgos;

class HallazgoGuardado
{
    use Dispatchable, SerializesModels;

    public $hallazgo;
    public $usuarios;
    public $usuariosAuditoria;
    public $accion; // 'creado' o 'actualizado'

    public function __construct(Hallazgos $hallazgo, $usuarios, $usuariosAuditoria, string $accion)
    {
        $this->hallazgo = $hallazgo;
        $this->usuarios = $usuarios;
        $this->usuariosAuditoria = $usuariosAuditoria;
        $this->accion = $accion;
    }
}
