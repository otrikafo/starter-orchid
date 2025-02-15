<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Si vous utilisez l'authentification Laravel
use Pusher\Pusher;

class PusherAuthController extends Controller
{
    public function authorize(Request $request)
    {
        // 1. Récupérer le nom du canal et l'ID du socket depuis la requête
        $channelName    = $request->channel_name;
        $socketId       = $request->socket_id;

        // 2. (Optionnel) Effectuer des vérifications d'autorisation supplémentaires si nécessaire
        // Par exemple, vérifier si l'utilisateur a le droit d'accéder à cette "room" de chat spécifique
        // Vous pouvez utiliser Auth::check() pour vérifier si l'utilisateur est authentifié,
        // et potentiellement vérifier des rôles ou des permissions spécifiques.
        // Pour cet exemple simple, nous allons autoriser tous les utilisateurs authentifiés à rejoindre les canaux privés.

        if (!Auth::guard('visiteur')->check()) { // Exemple : Autoriser seulement les utilisateurs authentifiés
            return response()->json(['error' => 'Non authentifié'], 403); // Retourner une erreur 403 si non authentifié
        }

        // 3. Instancier l'objet Pusher avec vos clés d'identification
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );

        // 4. Générer les données d'autorisation pour le canal privé
        $authData = $pusher->socket_auth($channelName, $socketId);

        // 5. Retourner les données d'autorisation au format attendu par Pusher JavaScript
        return response($authData, 200)->header('Content-Type', 'application/json');
    }
}
