<?php

namespace App\Notifications\Visiteur;

use App\Models\Visiteur;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VisiteurRegisteredNotification extends Notification
{
    use Queueable;

    public $visiteur;
    /**
     * Create a new notification instance.
     */
    public function __construct(Visiteur $visiteur)
    {
        $this->visiteur = $visiteur;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Visiteur Registered Mail')
            ->markdown('emails.visiteur.registered', [ // Utilisez ->markdown() et le chemin du template Blade
                'visiteur' => $this->visiteur, // Passez les données au template Blade
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
