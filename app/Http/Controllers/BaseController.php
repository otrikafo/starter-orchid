<?php

namespace App\Http\Controllers; // Important : Assurez-vous du bon namespace

use App\Http\Controllers\Controller; // Importer la classe Controller de base de Laravel
use Inertia\Inertia;
use Inertia\Response;

class BaseController extends Controller // Étend la classe Controller de Laravel
{
    /**
     * Renders an Inertia view with breadcrumbs.
     *
     * This method takes care of rendering an Inertia view and automatically
     * merges default breadcrumbs with page-specific breadcrumbs.
     *
     * @param string $component The name of the Inertia component to render.
     * @param array $props An array of props to pass to the Inertia component.
     * @param array $breadcrumbs An array of breadcrumb segments specific to this page.
     * @return \Inertia\Response
     */
    protected function renderWithBreadcrumbs(string $component, array $props = [], array $breadcrumbs = []): Response
    {
        // Définir les breadcrumbs par défaut (par exemple, toujours inclure "Accueil Visiteur")
        $defaultBreadcrumbs = [
            ['label' => 'Accueil', 'route' => 'home'], // Assurez-vous que 'visitor.home' est votre route d'accueil
        ];

        // Fusionner les breadcrumbs par défaut avec les breadcrumbs spécifiques à la page
        $mergedBreadcrumbs = array_merge($defaultBreadcrumbs, $breadcrumbs);
        $props = array_merge($props, ['breadcrumbs' => $mergedBreadcrumbs]);
        // Rendre la vue Inertia, en ajoutant les breadcrumbs fusionnés aux props
        return Inertia::render($component, $props);
    }
}
