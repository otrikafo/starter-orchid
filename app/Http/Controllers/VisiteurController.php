<?php

namespace App\Http\Controllers;

use App\Events\ContactFormSubmitted;
use App\Http\Requests\VisiteurRegisterRequest;
use App\Models\Agence;
use App\Models\Bien;
use App\Models\Visiteur;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\VisiteurLoginRequest; // Importez VisiteurLoginRequest
use App\Mail\AdminNotificationNewVisiteurMail;
use App\Mail\VisiteurRegisteredMail;
use App\Models\AvisAgence;
use App\Models\Contact;
use App\Notifications\Agence\AgenceNotificationContactFormAgence;
use App\Notifications\Agence\NotificationContactFormAgence;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Notification;

class VisiteurController extends Controller
{
    public function indexBiens(): Response
    {
        $biens = Bien::with('agence') // Eager loading pour éviter le N+1 problem
            ->paginate(12); // Pagination, 12 biens par page
        // Charger les relations pour les images secondaires
        $biens->load('imagesSecondaires');
        return Inertia::render('Visiteur/Biens/Index', [ // Vue Inertia pour la liste des biens
            'biens' => $biens,
        ]);
    }

    public function afficherBien(Bien $bien): Response
    {
        $bien->load('agence', 'imagesSecondaires'); // Charger les relations pour la page de détail

        return Inertia::render('Visiteur/Biens/Show', [ // Vue Inertia pour le détail d'un bien
            'bien' => $bien,
        ]);
    }

    // afficherAgence
    public function afficherAgence(Agence $agence): Response
    {
        $agence->load('biens'); // Charger les biens de l'agence
        $agence->load('avisAgences'); // Charger le nombre d'avis de l'agence
        // Charger les relations pour l'avis avec le visiteur
        $agence->load('avisAgences.visiteur');
        // Identifier si le visiteur a déjà laissé un avis
        $visiteur = Auth::guard('visiteur')->user();
        $aDejaLaisseAvis = false;
        if ($visiteur) {
            $aDejaLaisseAvis = $agence->avisAgences->contains('visiteur_id', $visiteur->id);
        }
        return Inertia::render('Visiteur/Agences/Show', [ // Vue Inertia pour le détail
            'agence' => $agence,
            'aDejaLaisseAvis' => $aDejaLaisseAvis,
        ]);
    }
    // indexAgences
    public function indexAgences(): Response
    {
        $agences = Agence::paginate(4); // Pagination, 12 agences par page

        return Inertia::render('Visiteur/Agences/Index', [ // Vue Inertia pour la liste des agences
            'agences' => $agences,
        ]);
    }
    // Page d'inscription
    public function inscription()
    {
        // Si déjà connecté, redirigez vers le tableau de bord
        if (Auth::guard('visiteur')->check()) {
            return Inertia::location(route('visiteur.mon-compte'));
        }
        return Inertia::render('Visiteur/Inscription'); // Vue Inertia pour l'inscription
    }

    public function enregistrerVisiteur(VisiteurRegisterRequest $request)
    {
        $visiteur = Visiteur::create([
            'id' => Str::uuid(),
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // Forecer la connexion après l'inscription
        Auth::guard('visiteur')->login($visiteur);
        Mail::to($visiteur->email)->send(new VisiteurRegisteredMail($visiteur));
        Mail::to(config('mail.admin_email'))->send(new AdminNotificationNewVisiteurMail($visiteur));

        return Inertia::location(route('visiteur.inscription.confirmation')); // Redirection Inertia
    }

    public function seConnecterVisiteur()
    {
        // Si déjà connecté, redirigez vers le tableau de bord
        if (Auth::guard('visiteur')->check()) {
            return Inertia::location(route('visiteur.mon-compte'));
        }
        return Inertia::render('Visiteur/Connexion'); // Vue Inertia pour la connexion visiteur
    }

    public function authentifierVisiteur(VisiteurLoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('visiteur')->attempt($credentials, $request->remember)) { // Utilisez le guard 'visiteur'
            $request->session()->regenerate();
            // Add user datas in session?
            $request->session()->flash('success', 'Vous êtes connecté.');
            return Inertia::location(route('home')); // Redirigez vers la page d'accueil après connexion
        }

        return back()->withErrors([ // En cas d'échec d'authentification
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function deconnecterVisiteur(FormRequest $request)
    {
        Auth::guard('visiteur')->logout(); // Déconnexion avec le guard 'visiteur'

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Inertia::location(route('home')); // Redirigez vers la page d'accueil après déconnexion
    }

    // monCompte
    public function monCompte(): Response
    {
        $visiteur = Auth::guard('visiteur')->user(); // Récupérez le visiteur connecté

        return Inertia::render('Visiteur/MonCompte', [ // Vue Inertia pour le compte visiteur
            'visiteur' => $visiteur,
        ]);
    }

    // enregistrerAvis
    public function enregistrerAvisAgence(FormRequest $request)
    {
        // Récupérer l'agence dans l'url sous forme de /agences/{agence:id}/avis
        $agenceId = $request->route('agence');
        $avis = $request->note;
        $visiteur = Auth::guard('visiteur')->user();
        $avis = new AvisAgence([
            'id' => Str::uuid(),
            'agence_id' => $agenceId,
            'auteur' => $visiteur->nom,
            'note' => $avis,
            'visiteur_id' => $visiteur->id,
            'commentaire' => $request->commentaire,
        ]);
        $avis->save();

        return back()->with('success', 'Votre avis a été enregistré.');
    }

    // contacterAgence
    public function contacterAgence(FormRequest $request)
    {
        $visiteur = Auth::guard('visiteur')->user();
        $bienId       = $request->route('bien');
        $bien         = Bien::find($bienId);
        $contenu    = $request->message;
        $agence     = $bien->agence;
        // Créer le contact
        Contact::create(
            [
                'id' => Str::uuid(),
                'bien_id' => $bien->id,
                'visiteur_id' => $visiteur->id,
                'message' => $contenu,
            ]
        );
        // Lancer l'événement pour notifier l'agence
        ContactFormSubmitted::dispatch(
            $bien,
            $agence,
            $visiteur,
            $contenu ?? '' // Message peut être null, on met une chaîne vide par défaut
        );


        return back()->with('success', 'Votre message a été envoyé.');
    }
}
