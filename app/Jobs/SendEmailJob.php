<?php

namespace App\Jobs;

use App\Mail\HuberCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $send_mail;
    protected $huber;
    protected $plantilla;
    protected $files;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_mail, $huber, $plantilla, $files = null)
    {
        $this->send_mail = $send_mail;
        $this->huber = $huber;
        $this->plantilla = $plantilla;
        $this->files = $files;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->send_mail)->send(new HuberCreated($this->huber, $this->plantilla, $this->files));
    }
}
