<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Visiteur;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Visiteur $visiteur;
    public Message $message;
    public string $roomId;
    /**
     * Create a new event instance.
     */
    public function __construct(Visiteur $visiteur, Message $message, string $roomId)
    {
        $this->visiteur = $visiteur;
        $this->message = $message;
        $this->roomId = $roomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel($this->roomId),
        ];
    }

    // /**
    //  * The event's broadcast name.
    //  *
    //  * @return string
    //  */
    // public function broadcastAs()
    // {
    //     return 'message.sent'; // Nom de l'événement diffusé sur Pusher
    // }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'sender' => $this->visiteur,
            'message' => $this->message,
            'timestamp' => now()->toIso8601String(), // Ajouter un timestamp pour l'affichage côté client
        ];
    }
}
