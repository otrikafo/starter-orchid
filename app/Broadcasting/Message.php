<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Models\Visiteur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Message
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(Visiteur $user, $roomId): array|bool
    {
        Log::info("Visiteur ID: {$user->id} Room ID: {$roomId}");
        return Auth::guard('visiteur')->check() && $user->id === Auth::guard('visiteur')->user()->id;
    }
}
