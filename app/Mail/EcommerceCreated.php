<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EcommerceCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $subjetc = "Información DingDone Ecommerce";

    protected $ecom;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ecom)
    {
        $this->ecom = $ecom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjetc)->view('mail.inforecibidaecommerce', ['ecom' => $this->ecom]);
    }
}
