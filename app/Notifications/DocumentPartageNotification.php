<?php

namespace App\Notifications;

use App\Events\CourrierPartage;
use App\Models\CourriersPartage;
use App\Models\DocumentFollower;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentPartageNotification extends Notification
{
    use Queueable;

    public $partage;
    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DocumentFollower $partage, $message)
    {
        $this->partage = $partage;
        $this->message = $message;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
                    'name' => $this->partage->agent->prenom.' '.$this->partage->agent->nom,
                    'image' => $this->partage->agent->image
                ],
                'message' => $this->message,
                'object' => $this->partage->document?->document,
                'partage' => $this->partage
            ]
        ];
    }
}
