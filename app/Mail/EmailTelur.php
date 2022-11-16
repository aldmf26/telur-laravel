<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailTelur extends Mailable
{
    use Queueable, SerializesModels;
    public $tgl1, $tgl2;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tgl1,$tgl2)
    {
        $tgl1 = $this->tgl1;
        $tgl2 = $this->tgl2;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('cornjob.email');
    }
}
