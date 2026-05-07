<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordarPass extends Mailable
{
    use Queueable, SerializesModels;

    public $subjetc = "Recuperar contraseña";

    private $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->customer = Customer::where('token', $token)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subjetc)
            ->view('mail.recordarPass', [
                "customer" => $this->customer
            ]);
    }
}
