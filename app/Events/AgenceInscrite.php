<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Agence; // Importez le modèle Agence

class AgenceInscrite
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $agence; // Propriété pour stocker l'instance de l'agence

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Agence  $agence
     * @return void
     */
    public function __construct(Agence $agence)
    {
        $this->agence = $agence;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-agence-inscription'); // Canal de diffusion (pour les websockets, etc., pas nécessaire ici pour les notifications classiques)
    }
}
