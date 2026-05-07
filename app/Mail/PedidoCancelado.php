<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoCancelado
extends Mailable
{
    use Queueable, SerializesModels;

    private $pedido;
    private $motivo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, $motivo)
    {
        $this->pedido = $pedido;
        $this->motivo = $motivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pedido = $this->pedido;
        $motivo = $this->motivo;

        return $this->view('mail.pedidoCancelado', compact('pedido', 'motivo'));
    }
}
