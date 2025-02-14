<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Agence; // Importez le modèle Agence

class AdminNotificationNewAgency extends Notification implements ShouldQueue
{
    use Queueable;

    public $agence; // Propriété pour stocker l'instance de l'agence

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Agence  $agence
     * @return void
     */
    public function __construct(Agence $agence)
    {
        $this->agence = $agence;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Canaux de notification : e-mail et base de données
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
            ->subject('Admin Notification New Agency Mail')
            ->markdown('emails.admin.new_agence', [ // Utilisez ->markdown() et le chemin du template Blade
                'agence' => $this->agence, // Passez les données au template Blade
            ]);
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
            'agence_id' => $this->agence->id,
            'raison_sociale' => $this->agence->raison_sociale,
            'email' => $this->agence->email,
            'message' => 'Une nouvelle agence s\'est inscrite : ' . $this->agence->raison_sociale,
            // Vous pouvez ajouter d'autres données à stocker dans la base de données
        ];
    }
}
