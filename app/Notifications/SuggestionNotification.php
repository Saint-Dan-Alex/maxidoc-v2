<?php

namespace App\Notifications;

use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuggestionNotification extends Notification
{
    use Queueable;

    public $suggestion;
    public $message;
    public $author;
    public $type; // 'new' or 'status_update'

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Suggestion $suggestion, User $author, $message, $type = 'new')
    {
        $this->suggestion = $suggestion;
        $this->author = $author;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => [
                'agent' => [
                    'name' => $this->author->name,
                    'image' => $this->author->agent?->image,
                    'service' => $this->author->agent?->service?->titre ?? 'Non Défini'
                ],
                'message' => $this->message,
                'object' => $this->suggestion->objet,
                'suggestion_id' => $this->suggestion->id,
                'type' => $this->type,
            ]
        ];
    }
}
