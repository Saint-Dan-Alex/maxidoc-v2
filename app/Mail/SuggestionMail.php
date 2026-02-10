<?php

namespace App\Mail;

use App\Models\Suggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuggestionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $suggestion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Nouveau retour utilisateur : ' . ucfirst($this->suggestion->type) . ' - ' . $this->suggestion->objet)
                    ->view('regidoc.emails.suggestion');

        if ($this->suggestion->image_path) {
            $mail->attachFromStorage($this->suggestion->image_path, null, ['disk' => 'public']);
        }

        return $mail;
    }
}
