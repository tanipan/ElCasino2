<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoCreado extends Mailable
{
    use Queueable, SerializesModels;

    private $cesta;
    private $customer;
    private $order;
    private $hora_recogida;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cesta, $customer, $order, $hora_recogida)
    {
        $this->cesta = $cesta;
        $this->customer = $customer;
        $this->order = $order;
        $this->hora_recogida = $hora_recogida;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cesta = $this->cesta;
        $customer = $this->customer;
        $order = $this->order;
        $hora_recogida = $this->hora_recogida;

        return $this->view('mail.pedidoRealizado', compact('cesta', 'order', 'customer','hora_recogida'));
    }
}
