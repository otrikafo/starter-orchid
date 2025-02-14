<?php

namespace App\Listeners;

use App\Events\VisiteurInscrit;
use App\Notifications\Visiteur\VisiteurRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifierNewVisiteur implements ShouldQueue
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
    public function handle(VisiteurInscrit $event): void
    {
        // Récupérez le visiteur depuis l'event
        $visiteur = $event->visiteur;

        // Envoyer la notification à l'administrateur (en utilisant une Notification Laravel)
        Notification::route('mail', $visiteur->email) // Route de notification (ici, e-mail à l'admin)
            ->notify(new VisiteurRegisteredNotification($visiteur)); // Notifier l'admin avec la notification et le visiteur
    }
}
