<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent; // Importez l'Event ChatMessageSent
use App\Models\Agence;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Si vous utilisez l'authentification Laravel
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ChatController extends BaseController
{
    public function startPrivateChat(Request $request)
    {
        $validatedData = $request->validate([
            'agence_id' => 'required|uuid',
        ]);
        $agenceId = $validatedData['agence_id'];
        $visiteur = Auth::guard('visiteur')->user();
        // Vérifier si une salle existe déjà entre ce visiteur et cette agence
        $room = Room::where('visiteur_id', $visiteur->id)
            ->where('agence_id', $agenceId)
            ->first();

        if ($room) {
            $roomId = $room->id; // Réutiliser la salle existante
        } else {
            // Créer une nouvelle salle
            $room = Room::create([
                'visiteur_id' => $visiteur->id,
                'agence_id' => $agenceId,
            ]);
            $roomId = $room->id;
        }
        $room->load('visiteur', 'agence', 'messages'); // Charger les relations visiteur, agence et
        $room->load('messages.sender');
        return response()->json(['roomId' => $roomId, 'room' => $room]); // Retourner l'ID de la salle
    }

    public function sendMessage(Request $request)
    {
        // 1. Validation des données reçues du frontend (message, roomId)
        $validatedData = $request->validate([
            'message' => 'required|string',
            'roomId' => 'required|string', // ou 'required|integer' si roomId est un ID numérique
        ]);

        $message    = $validatedData['message'];
        $roomId     = $validatedData['roomId'];
        $room       = Room::findOrFail($roomId); // Récupérez la salle par ID
        $sender     = Auth::guard('visiteur')->user(); // Remplacez 'guardName' par le nom de votre garde si vous en utilisez un
        // Si les visiteurs ne sont pas authentifiés, vous devrez peut-être gérer l'identité du visiteur différemment

        $message = $sender->messages()->create([
            'id'        => Str::uuid(),
            'message' => $message,
            'sender_id' => $sender ? $sender->id : null, // ou un identifiant visiteur temporaire
            'room_id' => $roomId,
        ]);
        // 3. Dispatcher l'Event ChatMessageSent pour diffuser le message via Pusher
        broadcast(new ChatMessageSent($sender, $message, $room)); // Is it consistently using broadcast()?
        return response()->json(['status' => 'App\\Events\\ChatMessageSent']);
    }

    /**
     * Display the chat index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visiteur = Auth::guard('visiteur')->user();
        $rooms = Room::where('visiteur_id', $visiteur->id)->get(); // Récupérez les salles pour ce visiteur
        $rooms->load('agence', 'messages'); // Charger les relations agence et messages
        return $this->renderWithBreadcrumbs(
            'Chat/Index',
            [
                'rooms' => $rooms,
                'sender' => $visiteur
            ],
            [
                ['label' => 'Chat', 'route' => 'chat.index', 'active' => true],
            ]
        );
    }

    /**
     * Display the specified chat.
     *
     * @param  int  $roomId
     * @return \Illuminate\Http\Response
     */
    public function room($roomId)
    {
        $room       = Room::findOrFail($roomId); // Récupérez la salle par ID
        $visiteur   = Auth::guard('visiteur')->user();
        $room->load('visiteur', 'agence', 'messages'); // Charger les relations visiteur et agence
        $room->load('messages.sender');
        $initialMessages = $this->fetchMessages(request()->merge(['page' => 1, 'roomId' => $roomId])); // Passer roomId à fetchMessages
        return $this->renderWithBreadcrumbs(
            'Chat/Room/Index',
            [
                'roomId' => $roomId,
                'room' => $room,
                'initialMessages' => $initialMessages,
                'sender' => $visiteur,
            ],
            [
                ['label' => 'Chat', 'route' => 'chat.index'],
                ['label' => 'Room', 'route' => 'chat.show', 'params' => ['room' => $roomId], 'active' => true,],
            ]
        );
    }

    /**
     * Fetch messages for the specified room.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchMessages(Request $request)
    {
        $perPage = 100; // Nombre de messages par "page" (chunk) pour l'infinite scroll
        $page = $request->get('page', 1); // Récupérer le numéro de page depuis la requête (par défaut page 1)

        $roomId = $request->get('roomId');
        $messages = Message::where('room_id', $roomId) // Filtrer par roomId si nécessaire
            ->orderBy('created_at', 'ASC') // Important : trier par date de création DESC pour charger les plus récents en premier
            ->skip(($page - 1) * $perPage) // Calculer l'offset (nombre de messages à sauter)
            ->take($perPage) // Limiter le nombre de messages par page
            ->get();
        $messages->load('sender');
        return $messages;
    }
}
