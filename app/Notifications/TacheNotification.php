<?php

namespace App\Notifications;

use App\Models\Tache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;

class TacheNotification extends Notification
{
    use Queueable;

    public $tache;
    public $message;
    public $agent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Tache $tache, $message, $agent = null)
    {
        $this->tache = $tache;
        $this->message = $message;
        $this->agent = $agent ?? $tache->user->agent;
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
            ->title($this->agent->prenom.' '.$this->agent->nom)
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
                    'name' => $this->agent->prenom.' '.$this->agent->nom,
                    'image' => $this->agent->image ?? null
                ],
                'message' => $this->message,
                'object' => '',
                'tache' => $this->tache,
            ]
        ];
    }
}
