<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;

class NotificacionesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($proyecto , $timeline)
    {
      $this->proyecto = $proyecto;
      $this->timeline = $timeline;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

      return $this->subject('Avances en el proyecto '.$this->proyecto)
                  ->view('mails.cliente')
                  ->with([
                        'proyecto' => $this->proyecto,
                        'timeline' => $this->timeline
                    ]);
    }
}
