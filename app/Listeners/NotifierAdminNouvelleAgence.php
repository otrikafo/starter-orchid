<?php

namespace App\Listeners;

use App\Events\AgenceInscrite;
use App\Notifications\Admin\AdminNotificationNewAgency;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification; // Facade Notification

class NotifierAdminNouvelleAgence implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \App\Events\AgenceInscrite  $event
     * @return void
     */
    public function handle(AgenceInscrite $event)
    {
        // Récupérez l'agence depuis l'event
        $agence = $event->agence;

        // Envoyer la notification à l'administrateur (en utilisant une Notification Laravel)
        Notification::route('mail', config('mail.admin_email')) // Route de notification (ici, e-mail à l'admin)
            ->notify(new AdminNotificationNewAgency($agence)); // Notifier l'admin avec la notification et l'agence
    }

    /**
     * Détermine si le listener doit être mis en file d'attente.
     *
     * @param  \App\Events\AgenceInscrite  $event
     * @return bool
     */
    public function shouldQueue(AgenceInscrite $event)
    {
        return true; // Toujours mettre en queue ce listener
    }

    /**
     * Configuration de la queue (facultatif, si vous voulez personnaliser la queue)
     *
     * @return string
     */
    public function viaQueue()
    {
        return 'notifications'; // Nom de la queue (vous pouvez la créer dans config/queue.php)
    }
}
