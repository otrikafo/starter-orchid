<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent; // Importez l'Event ChatMessageSent
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Si vous utilisez l'authentification Laravel
use Illuminate\Support\Str;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // 1. Validation des données reçues du frontend (message, roomId)
        $validatedData = $request->validate([
            'message' => 'required|string',
            'roomId' => 'required|string', // ou 'required|integer' si roomId est un ID numérique
        ]);

        $message = $validatedData['message'];
        $roomId = $validatedData['roomId'];

        // 2. Récupérer l'utilisateur qui envoie le message (si authentification)
        $sender = Auth::guard('visiteur')->user(); // Remplacez 'guardName' par le nom de votre garde si vous en utilisez un
        // Si les visiteurs ne sont pas authentifiés, vous devrez peut-être gérer l'identité du visiteur différemment
        // (par exemple, en utilisant une session ou un identifiant temporaire)

        $message = new Message([
            'id'        => Str::uuid(),
            'message' => $message,
            'sender_id' => $sender ? $sender->id : null, // ou un identifiant visiteur temporaire
            'room_id' => $roomId,
        ]);
        $message->save();
        // 3. Dispatcher l'Event ChatMessageSent pour diffuser le message via Pusher
        ChatMessageSent::dispatch($sender, $message, $roomId);

        // 4. (Optionnel) Enregistrer le message dans la base de données (si vous voulez un historique)
        // Vous pouvez créer un modèle Message et enregistrer le message, l'utilisateur, le roomId, etc. ici
        // Exemple (nécessite de créer un modèle Message et une migration) :
        // \App\Models\Message::create([
        //     'user_id' => $user ? $user->id : null, // ou un identifiant visiteur temporaire
        //     'room_id' => $roomId,
        //     'message' => $message,
        // ]);

        // 5. Retourner une réponse JSON (succès) au frontend
        return response()->json(['status' => 'App\\Events\\ChatMessageSent']);
    }

    public function index()
    {
        // Get visiteur from auth guard
        $visiteur = Auth::guard('visiteur')->user();
        // Get all messages
        $initialMessages = $this->fetchMessages(request()->merge(['page' => 1])); // Charger la première page de messages au chargement initial
        $initialMessages->load('sender');
        return Inertia::render('Chat/Index', [
            'messages' => $initialMessages,
            'roomId' => 'chat-room',
        ]);
    }

    public function fetchMessages(Request $request)
    {
        $perPage = 5; // Nombre de messages par "page" (chunk) pour l'infinite scroll
        $page = $request->get('page', 1); // Récupérer le numéro de page depuis la requête (par défaut page 1)

        $messages = Message::where('room_id', 'chat-room') // Filtrer par roomId si nécessaire
            ->orderBy('created_at', 'desc') // Important : trier par date de création DESC pour charger les plus récents en premier
            ->skip(($page - 1) * $perPage) // Calculer l'offset (nombre de messages à sauter)
            ->take($perPage) // Limiter le nombre de messages par page
            ->get();
        $messages->load('sender');
        return $messages;
        // return Message::with('sender')->get();
    }

    // Controlleur pour créer un chat room initié au clic sur un bouton dans le frontend
    public function createChatRoom(Request $request)
    {
        $roomId = Str::uuid();
        // Render room view
    }
}
