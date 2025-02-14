<?php

namespace App\Notifications\Agence;

use App\Models\Agence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Bien; // Importez le modèle Bien
use App\Models\Visiteur;
use Illuminate\Mail\Mailables\Content;

class AgenceNotificationContactFormAgence extends Notification implements ShouldQueue
{
    use Queueable;

    public $bien;
    public $visiteur;
    public $agence;
    public $visiteurMessage;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Bien  $bien
     * @param  string  $visiteurNom
     * @param  string  $visiteurEmail
     * @param  string  $visiteurMessage
     * @return void
     */
    public function __construct(Visiteur $visiteur, Agence $agence, Bien $bien, public string $message)
    {
        $this->bien = $bien;
        $this->visiteur = $visiteur;
        $this->agence = $agence;
        $this->visiteurMessage = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // E-mail et base de données
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $agence = $this->bien->agence; // Récupérez l'agence à partir du bien

        return (new MailMessage)
            ->subject('Nouveau message de contact pour le bien "' . $this->bien->titre . '"')
            ->markdown('emails.agence.contact', [ // Utilisez ->markdown() et le chemin du template Blade
                'agence' => $agence, // Passez les données au template Blade
                'visiteurNom' => $this->visiteur->nom,
                'visiteurEmail' => $this->visiteur->email,
                'visiteurMessage' => $this->visiteurMessage,
                'visiteur' => $this->visiteur,
                'bien' => $this->bien,
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
            'bien_id' => $this->bien->id,
            'agence_id' => $this->bien->agence->id,
            'message' => 'Nouveau contact pour le bien : ' . $this->bien->titre . ' de ' . $this->visiteurNom,
            // Ajoutez d'autres données si nécessaire
        ];
    }
}
