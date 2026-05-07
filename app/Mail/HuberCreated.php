<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HuberCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $subjetc = "Información DingDone";

    protected $huber;
    protected $plantilla;
    protected $files;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($huber, $plantilla, $files = null)
    {
        $this->huber = $huber;
        $this->plantilla = $plantilla;
        $this->files = $files;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->plantilla == 1) {
            return $this->subject($this->subjetc)->view('mail.inforecibida', ['huber' => $this->huber]);
        } elseif ($this->plantilla == 2) {
            return $this->subject($this->subjetc)->view('mail.enhorabuena', ['huber' => $this->huber]);
        } elseif ($this->plantilla == 3) {
            return $this->subject($this->subjetc)->view('mail.felicidades', ['huber' => $this->huber]);
        } elseif ($this->plantilla == 4) {
            return $this->subject($this->subjetc)->view('mail.losentimos', ['huber' => $this->huber]);
        } elseif ($this->plantilla == 6) {
            return $this->subject($this->subjetc)->view('mail.remoto2', ['huber' => $this->huber]);
        } elseif ($this->plantilla == 5) {
            return $this->subject("El hubber " . $this->huber->name . " " . $this->huber->lastname . " ha subido documentos")->view('mail.adjuntos', [
                'files' => $this->files,
                'huber' => $this->huber
            ]);
        }
    }
}
