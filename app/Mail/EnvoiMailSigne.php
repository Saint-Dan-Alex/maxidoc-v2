<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;

class EnvoiMailSigne extends Mailable  //implements ShouldQueue
{
    use Queueable, SerializesModels;

    
    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject("Code d'authentification eSignature MaxiDoc")
                    ->view('emails.signature');
    }
}
