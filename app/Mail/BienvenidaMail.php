<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;


class BienvenidaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jefe;
    public $empresa;
    public $departamento;
    public $puesto;
    public $motivo;
    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($jefe , $empresa , $departamento , $puesto ,$motivo , $id )
    {
      $this->jefe = $jefe;
      $this->empresa = $empresa;
      $this->departamento = $departamento;
      $this->puesto = $puesto;
      $this->motivo = $motivo;
      $this->id = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

      return $this->subject('Nueva Vacante')
                  ->view('mails.bienvenidos')
                  ->with([
                        'nombre' => $this->jefe ,
                        'empresa' => $this->empresa ,
                        'departamento' => $this->departamento ,
                        'puesto' => $this->puesto ,
                        'motivo' => $this->motivo ,
                        'id' => $this->id
                    ]);
    }
}
