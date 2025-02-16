<?php

namespace App\Listeners;

use App\Events\ChatMessageSent;
use App\Notifications\MessageReceivedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifierAfterMessageSent implements ShouldQueue
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
    public function handle(ChatMessageSent $event): void
    {
        $agence = $event->room->agence;
        $sender = $event->sender;
        $room = $event->room;
        $message = $event->message;
        $dest = $agence;
        if ($agence->id == $sender->id) {
            $dest = $event->room->visiteur;
        }
        // Envoyer la notification à l'administrateur (en utilisant une Notification Laravel)
        Notification::route('mail', $dest->email) // Route de notification (ici, e-mail à l'admin)
            ->notify(new MessageReceivedNotification($dest, $sender, $room, $message)); // Notifier l'admin avec la notification et le visiteur
    }
}
