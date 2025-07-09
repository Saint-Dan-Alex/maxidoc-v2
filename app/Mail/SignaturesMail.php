<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignaturesMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $password;

    /**
     * Crée une nouvelle instance du message.
     *
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * Construire le message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject("Code d'authentification eSignature MaxiDoc")
                    ->markdown('emails.signature')
                    ->with([
                        'password' => $this->password,
                    ]);
    }
}
