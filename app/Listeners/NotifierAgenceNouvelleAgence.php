<?php

namespace App\Listeners;

use App\Events\AgenceInscrite;
use App\Notifications\Agence\AgenceRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification; // Facade Notification

class NotifierAgenceNouvelleAgence implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AgenceInscrite $event): void
    {
        // Récupérez l'agence depuis l'event
        $agence = $event->agence;

        // Envoyer la notification à l'administrateur (en utilisant une Notification Laravel)
        Notification::route('mail', $agence->email) // Route de notification (ici, e-mail à l'admin)
            ->notify(new AgenceRegisteredNotification($agence)); // Notifier l'admin avec la notification et l'agence
    }
}
