<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => 'auth:visiteur']);

// Broadcast::channel('chat-room', function ($user) { // Dynamic channel name with {roomId}
//     return true; // TEMPORARY: Allow all for testing.  REVISE AUTHORIZATION LATER.
// });

Broadcast::channel('chat-room.{roomId}', function ($user, $roomId) { // Dynamic private channel with {roomId}
    return true; // TEMPORARY: Allow all for testing.  REVISE AUTHORIZATION LATER.
    // Get the room from the database using the roomId
    $room = \App\Models\Room::find($roomId);
    if (!$room) {
        return false; // Room not found
    }

    // Allow only if the user is linked to the room OR if the agency is linked to the room (you may need to adapt this based on your agency authentication)
    return $room->visiteur->id === $user->id;
});
// Broadcast::channel('private-chat-room.{roomId}', function ($visiteur, $roomId) { // Canal privé dynamique avec {roomId}
//     return true; // TEMPORAIRE: Autoriser tout pour les tests.  RÉVISER L'AUTORISATION PLUS TARD.
//     // Récupérer la salle depuis la base de données en utilisant le roomId
//     $room = \App\Models\Room::find($roomId);
//     if (!$room) {
//         return false; // Salle non trouvée
//     }

//     // Autoriser uniquement si le visiteur est lié à la salle OU si l'agence est liée à la salle (vous devrez peut-être adapter cela en fonction de votre authentification agence)
//     return $room->visiteur_id === $visiteur->id || $room->agence_id === /* Récupérer l'ID de l'agence authentifiée ici si vous avez une authentification agence*/ null; // Adapter l'autorisation agence
// });
