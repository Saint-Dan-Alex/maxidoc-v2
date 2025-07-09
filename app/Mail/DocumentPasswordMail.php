<?php

namespace App\Mail;

use App\Models\Image;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class DocumentPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $password;
    public User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password, User $user)
    {
        $this->password = $password;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('systeme@elik6.com', 'ADS SAAS'),
            subject: 'Mot de passe pour la lecture d\'un document confidentiel SUR ADS SAAS',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.document-password',
            with: [
                'password' => $this->password,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
