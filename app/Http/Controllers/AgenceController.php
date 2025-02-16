<?php

namespace App\Http\Controllers;

use App\Events\AgenceInscrite;
use App\Http\Controllers\BaseController;
use App\Http\Requests\AgenceLoginRequest;
use App\Http\Requests\AgenceRegisterRequest;
use App\Mail\AgenceRegisteredMail;
use App\Models\Agence;
use App\Models\AvisAgence;
use App\Models\Bien;
use App\Models\Fichier;
use App\Models\ImageSecondaire;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AgenceController extends BaseController
{
    public function inscription()
    {
        // Si déjà connecté, redirigez vers le tableau de bord
        if (Auth::guard('agence')->check()) {
            return Inertia::location(route('agence.dashboard'));
        }
        return $this->renderWithBreadcrumbs('Agence/Inscription', [], [ // Utiliser renderWithBreadcrumbs
            ['label' => 'Inscription', 'route' => 'visiteur.inscription', 'active' => true],
        ]);
    }

    public function enregistrerAgence(AgenceRegisterRequest $request)
    {
        $agence = Agence::create([
            'id' => Str::uuid(),
            'raison_sociale' => $request->raison_sociale,
            'siege' => $request->siege,
            'nif' => $request->nif,
            'stat' => $request->stat,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        AgenceInscrite::dispatch($agence); // Déclencher l'événement AgenceInscrite
        // Authentification après l'inscription
        Auth::guard('agence')->login($agence);

        return Inertia::location(route('agence.inscription.confirmation')); // Redirection Inertia
    }

    public function seConnecter()
    {
        // Si déjà connecté, redirigez vers le tableau de bord
        if (Auth::guard('agence')->check()) {
            return Inertia::location(route('agence.dashboard'));
        }
        // return Inertia::render('Agence/Connexion'); // Vue Inertia pour la connexion visiteur
        return $this->renderWithBreadcrumbs('Agence/Connexion', [], [
            ['label' => 'Connexion', 'route' => 'agence.connexion', 'active' => true],
        ]);
    }

    public function authentifierAgence(AgenceLoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('agence')->attempt($credentials, $request->remember)) { // Utilisez le guard 'visiteur'
            $request->session()->regenerate();
            // Add user datas in session?
            $request->session()->flash('success', 'Vous êtes connecté.');
            return Inertia::location(route('agence.dashboard')); // Redirigez vers la page d'accueil après connexion
        }

        return back()->withErrors([ // En cas d'échec d'authentification
            'email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.',
        ]);
    }

    public function deconnecterAgence(FormRequest $request)
    {
        Auth::guard('agence')->logout(); // Déconnexion avec le guard 'visiteur'

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Inertia::location(route('agence.connexion')); // Redirigez vers la page d'accueil après déconnexion
    }

    // monCompte
    public function monCompte(): Response
    {
        $agence = Auth::guard('agence')->user(); // Récupérez le agence connecté

        // return Inertia::render('Agence/MonCompte', [ // Vue Inertia pour le compte agence
        //     'agence' => $agence,
        // ]);
        return $this->renderWithBreadcrumbs(
            'Agence/MonCompte',
            [
                'agence' => $agence,
            ],
            [
                ['label' => 'Mon compte', 'route' => 'agence.mon-compte'],
            ]
        );
    }

    // dashboard
    public function dashboard(): Response
    {
        return Inertia::render('Agence/Dashboard'); // Vue Inertia pour le tableau de bord
    }

    // biens.index
    public function indexBiens(): Response
    {
        $agence = Auth::guard('agence')->user(); // Récupérez le agence connecté
        $biens = $agence->biens()->paginate(10); // Récupérez les biens de l'agence
        return $this->renderWithBreadcrumbs(
            'Agence/Biens/Index',
            [
                'biens' => $biens,
            ],
            [
                ['label' => 'Biens', 'route' => 'agence.biens.index'],
            ]
        );
    }

    // biens.create
    public function creerBien(): Response
    {
        // return Inertia::render('Agence/Biens/Create'); // Vue Inertia pour créer un bien
        return $this->renderWithBreadcrumbs(
            'Agence/Biens/Create',
            [],
            [
                ['label' => 'Biens', 'route' => 'agence.biens.index'],
                ['label' => 'Créer', 'route' => 'agence.biens.create', 'active' => true],
            ]
        );
    }

    // biens.store
    public function enregistrerBien(FormRequest $request)
    {
        $agence = Auth::guard('agence')->user(); // Récupérez le agence connecté
        // Créer un modèle Fichier pour l'image principale
        $bien = $agence->biens()->create([
            'id' => Str::uuid(),
            'titre' => $request->titre,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'ville' => $request->ville,
            'prix' => $request->prix,
            'superficie' => $request->superficie,
            'nombre_pieces' => $request->nombre_pieces,
            'nombre_chambres' => $request->nombre_chambres,
            'nombre_salles_de_bain' => $request->nombre_salles_de_bain,
            'type_bien' => $request->type_bien,
            'type_transaction' => $request->type_transaction,
            'image_principale' => $request->image_principale,
        ]);
        if ($request->hasFile('image_principale')) {
            $imagePath = $request->file('image_principale')->store('biens/' . $bien->id, 'public'); // Stockage local dans /storage/app/public/biens/{bienId}
            $bien->image_principale = $imagePath;
            $bien->save();
        }

        return Inertia::location(route('agence.biens.show', ['bien' => $bien->id])); // Redirection Inertia
    }

    // biens.show
    public function afficherBien($bien): Response
    {
        $agence = Auth::guard('agence')->user(); // Récupérez le agence connecté
        $bien = $agence->biens()->findOrFail($bien); // Récupérez le bien de l'agence
        // Load relations
        $bien->load('imagesSecondaires', 'agence');
        return Inertia::render('Agence/Biens/Show', [ // Vue Inertia pour voir un bien
            'bien' => $bien,
        ]);
    }

    // biens.edit
    public function modifierBien($bien): Response
    {
        $agence = Auth::guard('agence')->user(); // Récupérez le agence connecté
        $bien = $agence->biens()->findOrFail($bien); // Récupérez le bien de l'agence
        return Inertia::render('Agence/Biens/Edit', [ // Vue Inertia pour éditer un bien
            'bien' => $bien,
        ]);
    }

    // biens.update
    public function mettreAJourBien(FormRequest $request, Bien $bien)
    {
        $validated = $request->validate([
            'titre' => 'string|max:255',
            'description' => 'nullable|string',
            'prix' => 'numeric|min:0',
            'adresse' => 'string|max:255',
            'ville' => 'string|max:255',
            'superficie' => 'nullable|numeric|min:0',
            'nombre_pieces' => 'nullable|integer|min:0',
            'nombre_chambres' => 'nullable|integer|min:0',
            'nombre_salles_de_bain' => 'nullable|integer|min:0',
            'type_bien' => 'string|in:maison,appartement,terrain,commerce',
            'type_transaction' => 'string|in:vente,location',
            // 'image_principale' => ['nullable', 'image', 'max:2048'], // Image is optional on update
        ]);

        $bien->update($validated);
        if ($request->hasFile('image_principale')) {

            $imagePath = $request->file('image_principale')->store('biens/' . $bien->id, 'public'); // Stockage local dans /storage/app/public/biens/{bienId}
            $bien->image_principale = $imagePath;
            $bien->save();
        }
        // Gestion des images secondaires
        if ($request->hasFile('images_secondaires')) {
            foreach ($request->file('images_secondaires') as $imageSecondaire) {
                $imageSecondairePath = $imageSecondaire->store('biens/images_secondaires', 'public');
                $fichier = Fichier::create([
                    'id'     => Str::uuid(),
                    'chemin' => $imageSecondairePath,
                    'nom_fichier' => $imageSecondaire->getClientOriginalName(),
                    'mime_type' => $imageSecondaire->getMimeType(),
                    'taille' => $imageSecondaire->getSize(),
                ]);
                ImageSecondaire::create([
                    'id'            => Str::uuid(),
                    'bien_id'       => $bien->id,
                    'fichier_id'    => $fichier->id,
                ]);
            }
        }
        return redirect()->route('agence.biens.index')->with('success', 'Bien immobilier mis à jour avec succès.');
    }

    /**
     * Récupère la liste des agences pour le chat.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAgenciesForChat()
    {
        $agencies = Agence::select('id', 'raison_sociale')->get(); // Récupérez les agences (sélectionnez au moins 'id' et 'raison_sociale')
        return response()->json($agencies); // Retournez la liste des agences en JSON
    }
}
