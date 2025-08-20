<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoNotificaciones extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreDestinatario;
    public $texto;
    public $ruta;
    public $tipo;

    /**
     * Create a new message instance.
     *
     * @param string $nombreDestinatario
     * @param string $texto
     */
    public function __construct($nombreDestinatario, $texto, $ruta , $tipo)
    {
        $this->nombreDestinatario = $nombreDestinatario;
        $this->texto = $texto;
        $this->ruta = $ruta;
        $this->tipo = $tipo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificación Junzi')
                    ->view('emails.notificacion');
    }
}
