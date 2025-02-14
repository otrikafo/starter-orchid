<?php

namespace App\Notifications\Agence;

use App\Models\Agence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgenceRegisteredNotification extends Notification
{
    use Queueable;
    public $agence;
    /**
     * Create a new notification instance.
     */
    public function __construct(Agence $agence)
    {
        $this->agence = $agence;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // E-mail et base de données
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Agence Registered Mail')
            ->markdown('emails.agence.registered', [ // Utilisez ->markdown() et le chemin du template Blade
                'agence' => $this->agence, // Passez les données au template Blade
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
