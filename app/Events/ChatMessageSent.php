<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Room;
use App\Models\Visiteur;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Authenticatable $sender;
    public Message $message;
    public Room     $room;
    /**
     * Create a new event instance.
     */
    public function __construct(Authenticatable $sender, Message $message, Room $room)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->room = $room;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {

        Log::info("chat-room.{$this->room->id}");
        return [
            // new Channel($this->room->id}");),
            // new PrivateChannel("chat-room.{$this->room->id}"),
            new Channel("chat-room.{$this->room->id}"),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    // public function broadcastAs()
    // {
    //     return 'App.Events.ChatMessageSent'; // Nom de l'événement diffusé sur Pusher
    // }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'sender' => $this->sender,
            'message' => $this->message,
            'roomId' => $this->room->id,
            'room' => $this->room,
            'timestamp' => now()->toIso8601String(), // Ajouter un timestamp pour l'affichage côté client
        ];
    }
}
