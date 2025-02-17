<?php

namespace App\Notifications;

use App\Models\Agence;
use App\Models\Message;
use App\Models\Room;
use App\Models\Visiteur;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\PusherPushNotifications\PusherChannel;
use NotificationChannels\PusherPushNotifications\PusherMessage;

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
        return ['mail', 'database', PusherChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info('Sending email to ' . $this->receiver->email);
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
    // public function toPushNotification($notifiable)
    // {
    //     Log::info('Sending push notification to ' . $this->receiver->email);
    //     $senderName = $this->sender instanceof Agence ? $this->sender->raison_social : $this->sender->prenom . ' ' . $this->sender->nom;
    //     $receiverName = $this->receiver instanceof Agence ? $this->receiver->raison_social : $this->receiver->prenom . ' ' . $this->receiver->nom;

    //     $message = "Nouveaux messages de " . $senderName . " pour " . $receiverName;
    //     $chatlink =  route('chat.show', ['room' => $this->room->id]);
    //     // return PusherMessage::create()
    //     //     ->iOS()
    //     //     ->badge(1)
    //     //     ->body($message)
    //     //     ->withAndroid(
    //     //         PusherMessage::create()
    //     //             ->title($message)
    //     //             ->icon('icon')
    //     //     );
    //     $beamsClient = new \Pusher\PushNotifications\PushNotifications(array(
    //         "instanceId" => "6fca8bea-937c-4c14-9eea-c5c9e564d91b",
    //         "secretKey" => "9F54E0326D501FC59BEC6F689A6A916072B0FD0F8E903749D0ED2ADFBFBCA9D6"

    //     ), new Client(['verify' => false]));


    //     return $beamsClient->publishToUsers(
    //         array("user-001", "user-002", "1"),
    //         array(
    //             "web" => array("notification" => array(
    //                 "title" => $message,
    //                 "body" => $message,
    //                 "deep_link" => $chatlink,
    //             )),
    //         )
    //     );
    // }
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
