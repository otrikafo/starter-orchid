<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent; // Importez l'Event ChatMessageSent
use App\Models\Message;
use App\Models\Room;
use App\Models\Visiteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Si vous utilisez l'authentification Laravel
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ChatAgenceController extends BaseController
{
    public function startPrivateChat(Request $request)
    {
        $validatedData = $request->validate([
            'agence_id' => 'required|uuid',
        ]);
        $agenceId = Auth::guard('agence')->user()->id;
        $visiteurId = $validatedData['visiteur_id'];
        $visiteur = Visiteur::findOrFail($visiteurId);

        // Vérifier si une salle existe déjà entre ce visiteur et cette agence
        $existingRoom = Room::where('visiteur_id', $visiteur->id)
            ->where('agence_id', $agenceId)
            ->first();

        if ($existingRoom) {
            $roomId = $existingRoom->id; // Réutiliser la salle existante
        } else {
            // Créer une nouvelle salle
            $room = Room::create([
                'visiteur_id' => $visiteur->id,
                'agence_id' => $agenceId,
            ]);
            $roomId = $room->id;
        }
        //  Rediriger vers le room?
        // return redirect()->route('chat.index', ['roomId' => $roomId]);
        return response()->json(['roomId' => $roomId]); // Retourner l'ID de la salle
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
        $sender     = Auth::guard('agence')->user(); // Remplacez 'guardName' par le nom de votre garde si vous en utilisez un
        // Si les agences ne sont pas authentifiés, vous devrez peut-être gérer l'identité du agence différemment

        $message = $sender->messages()->create([
            'id'        => Str::uuid(),
            'message' => $message,
            // 'sender_id' => $sender ? $sender->id : null, // ou un identifiant agence temporaire
            'room_id' => $roomId,
        ]);
        // 3. Dispatcher l'Event ChatMessageSent pour diffuser le message via Pusher
        broadcast(new ChatMessageSent($sender, $message, $room)); // Is it consistently using broadcast()?
        // Send mail
        // 5. Retourner une réponse JSON (succès) au frontend
        return response()->json(['status' => 'App\\Events\\ChatMessageSent']);
    }

    /**
     * Display the chat index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agence = Auth::guard('agence')->user();
        $rooms = Room::where('agence_id', $agence->id)->get(); // Récupérez les salles pour ce agence
        $rooms->load('agence', 'messages'); // Charger les relations agence et messages
        return $this->renderWithBreadcrumbs(
            'Chat/Agence/Index',
            [
                'rooms' => $rooms,
                'sender' => $agence
            ],
            [
                ['label' => 'Chat', 'route' => 'agence.chat.index'],
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
        $room->load('visiteur', 'agence', 'messages'); // Charger les relations visiteur et agence
        $room->load('messages.sender');
        $initialMessages = $this->fetchMessages(request()->merge(['page' => 1, 'roomId' => $roomId])); // Passer roomId à fetchMessages
        return $this->renderWithBreadcrumbs(
            'Chat/Agence/Room/Index',
            [
                'roomId'            => $roomId,
                'room'              => $room,
                'initialMessages'   => $initialMessages,
                'sender'            => $room->agence,
            ],
            [
                ['label' => 'Chat', 'route' => 'agence.chat.index'],
                ['label' => $room->visiteur->nom, 'route' => 'agence.chat.show', 'params' => ['room' => $roomId]],
            ]
        );
    }

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
        // return Message::with('sender')->get();
    }
}
