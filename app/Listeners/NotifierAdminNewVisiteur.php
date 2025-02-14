<?php

namespace App\Listeners;

use App\Events\VisiteurInscrit;
use App\Notifications\Admin\AdminNotificationNewVisiteur;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotifierAdminNewVisiteur implements ShouldQueue
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
        FacadesNotification::route('mail', config('mail.admin_email')) // Route de notification (ici, e-mail à l'admin)
            ->notify(new AdminNotificationNewVisiteur($visiteur)); // Notifier l'admin avec la notification et le visiteur
    }
}
