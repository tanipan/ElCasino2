<?php

namespace App\Jobs;

use App\Mail\EcommerceCreated;
use App\Mail\HuberCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailEcommerceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $send_mail;
    protected $ecom;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ecom)
    {
        $this->send_mail = "miguelpelegrin@gmail.com";
        $this->ecom = $ecom;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->send_mail)->send(new EcommerceCreated($this->ecom));
    }
}
