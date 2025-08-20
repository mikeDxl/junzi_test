<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;


class ReemplazarMail extends Mailable
{
    use Queueable, SerializesModels;

    public $colab;
    public $empresa;
    public $departamento;
    public $puesto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($colab , $empresa , $departamento , $puesto  )
    {
      $this->colab = $colab;
      $this->empresa = $empresa;
      $this->departamento = $departamento;
      $this->puesto = $puesto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

      return $this->subject('Actualización de puesto')
                  ->view('mails.reemplazar')
                  ->with([
                        'colab' => $this->colab ,
                        'empresa' => $this->empresa ,
                        'departamento' => $this->departamento ,
                        'puesto' => $this->puesto ,
                    ]);
    }
}
