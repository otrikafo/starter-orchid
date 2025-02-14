<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Bien; // Importez le modèle Bien
use App\Models\Agence; // Importez le modèle Agence
use App\Models\Visiteur; // Importez le modèle Visiteur (si vous avez un modèle visiteur authentifié, sinon vous pouvez passer les infos du formulaire)

class ContactFormSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bien;
    public $agence;
    public $visiteur; // Email du visiteur (depuis le formulaire)
    public $visiteurMessage; // Message du visiteur (depuis le formulaire)

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Bien  $bien
     * @param  \App\Models\Agence  $agence
     * @param  string  $visiteurNom
     * @param  string  $visiteurEmail
     * @param  string  $visiteurMessage
     * @return void
     */
    public function __construct(Bien $bien, Agence $agence, Visiteur $visiteur, string $visiteurMessage)
    {
        $this->bien = $bien;
        $this->agence = $agence;
        $this->visiteur = $visiteur;
        $this->visiteurMessage = $visiteurMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('contact-channel');
    }
}
