<?php

namespace App\Notifications;

use App\Models\Agence;
use App\Models\Message;
use App\Models\Room;
use App\Models\Visiteur;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MessageReceivedNotification extends Notification
{
    use Queueable;

    public Authenticatable $receiver;
    public Authenticatable $sender;
    public Room $room;
    public Message $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Authenticatable $receiver, Authenticatable $sender, Room $room, Message $message)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->room = $room;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $receiverName = $this->receiver instanceof Agence ? $this->receiver->raison_social : $this->receiver->prenom . ' ' . $this->receiver->nom;
        return (new MailMessage)
            ->subject('Nouveau message chat')
            ->markdown('emails.message-new', [ // Utilisez ->markdown() et le chemin du template Blade
                'sender' => $this->sender, // Passez les données au template Blade
                'agence' => $this->receiver,
                'room' => $this->room,
                'message' => $this->message,
                'receiverName' => $receiverName
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
            'sender' => $this->sender,
            'agence' => $this->receiver,
            'room' => $this->room,
            'message' => $this->message,
        ];
    }
}
