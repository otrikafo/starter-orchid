<?php

namespace App\Http\Controllers;

use App\Events\AgenceInscrite;
use App\Events\VisiteurInscrit;
use App\Models\Agence;
use App\Models\Visiteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends BaseController
{
    // Run test
    public function test()
    {
        // $agence = Agence::find("74822a1e-b5df-44f7-aefd-3d7c9f31f644");
        // AgenceInscrite::dispatch($agence);
        $visiteur = Visiteur::find("b12873b9-a206-4c0b-b016-b71c487fbf8d");
        VisiteurInscrit::dispatch($visiteur);
    }
    public function index()
    {
        // Tester si un visiteur est connecté
        // return Inertia::render('Home/Index');
        return $this->renderWithBreadcrumbs('Home/Index', [], []);
    }

    public function about()
    {
        // return Inertia::render('Home/APropos');
        return $this->renderWithBreadcrumbs('Home/APropos', [], [
            ['label' => 'A propos', 'route' => 'a-propos', 'active' => true],
        ]);
    }

    // Mentions légales
    public function mentionsLegales()
    {
        // return Inertia::render('Home/MentionsLegales');
        return $this->renderWithBreadcrumbs('Home/MentionsLegales', [], [
            ['label' => 'Mentions légales', 'route' => 'mentions-legales', 'active' => true],
        ]);
    }

    // politiqueConfidentialite
    public function politiqueConfidentialite()
    {
        // return Inertia::render('Home/PolitiqueConfidentialite');
        return $this->renderWithBreadcrumbs('Home/PolitiqueConfidentialite', [], [
            ['label' => 'Politique de confidentialité', 'route' => 'politique-confidentialite', 'active' => true],
        ]);
    }
}
