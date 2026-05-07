<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoAceptado
extends Mailable
{
    use Queueable, SerializesModels;

    private $pedido;
    private $hora;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pedido, $hora)
    {
        $this->pedido = $pedido;
        $this->hora = $hora;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pedido = $this->pedido;
        $hora = $this->hora;
        
        return $this->view('mail.pedidoAceptado', compact('pedido', 'hora'));
    }
}
