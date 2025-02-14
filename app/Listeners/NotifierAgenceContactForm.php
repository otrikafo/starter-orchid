<?php

namespace App\Listeners;

use App\Events\ContactFormSubmitted;
use App\Notifications\Agence\AgenceNotificationContactFormAgence;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\Agence\NotificationContactFormAgence; // Importez la notification pour l'agence
use Illuminate\Support\Facades\Notification;

class NotifierAgenceContactForm implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \App\Events\ContactFormSubmitted  $event
     * @return void
     */
    public function handle(ContactFormSubmitted $event)
    {
        $agence = $event->agence;
        // Ecrire sur le log
        // Envoyer la notification à l'agence
        Notification::route('mail', $agence->email) // Envoyer à l'email de l'agence
            ->notify(new AgenceNotificationContactFormAgence($event->visiteur, $event->agence, $event->bien, $event->visiteurMessage));
    }

    /**
     * Détermine si le listener doit être mis en file d'attente.
     *
     * @param  \App\Events\ContactFormSubmitted  $event
     * @return bool
     */
    public function shouldQueue(ContactFormSubmitted $event)
    {
        return true;
    }

    /**
     * Get the queue name for the listener.
     *
     * @return string|null
     */
    public function viaQueue()
    {
        return 'notifications';
    }
}
