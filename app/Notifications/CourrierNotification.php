<?php

namespace App\Notifications;

use App\Models\Agent;
use App\Models\Courrier;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;

class CourrierNotification extends Notification
{
    use Queueable;

    public $courrier;
    public $message;
    public $author;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Courrier $courrier, Agent $author, $message)
    {
        $this->courrier = $courrier;
        $this->author = $author;
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

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title($this->author?->prenom.' '.$this->author?->nom)
            // ->icon('/notification-icon.png')
            ->body($this->message)
            ->action('View App', 'notification_action');
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
                    'name' => $this->author?->prenom.' '.$this->author?->nom,
                    'image' => $this->author?->image
                ],
                'message' => $this->message,
                'object' => $this->courrier->document?->document,
                'courrier' => $this->courrier
            ]
        ];
    }
}
