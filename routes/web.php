<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\HomeController;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__ . '/auth.php';




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [HomeController::class, 'about'])->name('a-propos');
Route::get('/mentions-legales', [HomeController::class, 'mentionsLegales'])->name('mentions-legales');
Route::get('/politique-confidentialite', [HomeController::class, 'politiqueConfidentialite'])->name('politique-confidentialite');

// Routes pour les biens (visiteur)
Route::get('/biens', [VisiteurController::class, 'indexBiens'])->name('biens.index');
Route::get('/biens/{bien:id}', [VisiteurController::class, 'afficherBien'])->name('biens.show');

// Routes pour les agences (visiteur)
Route::get('/agences', [VisiteurController::class, 'indexAgences'])->name('agences.index');
Route::get('/agences/{agence:id}', [VisiteurController::class, 'afficherAgence'])->name('agences.show');
Route::post('/agences/{agence:id}/avis', [VisiteurController::class, 'enregistrerAvisAgence'])->name('agences.avis.store')->middleware('auth:visiteur'); // Middleware auth pour les avis

// Routes pour l'authentification Agence
Route::get('/agence/inscription', [AgenceController::class, 'inscription'])->name('agence.inscription');
Route::post('/agence/inscription', [AgenceController::class, 'enregistrerAgence']);
Route::get('/agence/inscription/confirmation', function () {
    return Inertia::render('Agence/InscriptionConfirmation');
})->name('agence.inscription.confirmation');
Route::get('/agence/connexion', [AgenceController::class, 'seConnecter'])->name('agence.connexion');
Route::post('/agence/connexion', [AgenceController::class, 'authentifierAgence']);
Route::post('/agence/deconnexion', [AgenceController::class, 'deconnecterAgence'])->name('agence.deconnexion')->middleware('auth:agence'); // Middleware auth pour la déconnexion
// Avis agence create
// Routes protégées pour les agences (middleware 'auth:agence')
Route::middleware(['auth:agence'])->prefix('agence')->group(function () {
    Route::get('/biens', [AgenceController::class, 'indexBiens'])->name('agence.biens.index');
    Route::get('/dashboard', [AgenceController::class, 'dashboard'])->name('agence.dashboard');
    Route::get('/biens/create', [AgenceController::class, 'creerBien'])->name('agence.biens.create');
    Route::post('/biens', [AgenceController::class, 'enregistrerBien'])->name('agence.biens.store');
    Route::get('/biens/{bien:id}', [AgenceController::class, 'afficherBien'])->name('agence.biens.show');
    Route::get('/biens/{bien:id}/edit', [AgenceController::class, 'modifierBien'])->name('agence.biens.edit');
    Route::post('/biens/{bien:id}', [AgenceController::class, 'mettreAJourBien'])->name('agence.biens.update');
    Route::delete('/biens/{bien:id}', [AgenceController::class, 'supprimerBien'])->name('agence.biens.destroy');
    Route::get('/avis', [AgenceController::class, 'voirAvis'])->name('agence.avis.index');
    Route::get('/contacts/{contact:id}/repondre', [AgenceController::class, 'repondreVisiteur'])->name('agence.contacts.repondre');
    Route::post('/contacts/{contact:id}/repondre', [AgenceController::class, 'envoyerReponseVisiteur'])->name('agence.contacts.reponse.store');
    // Mon compte
    Route::get('/mon-compte', [AgenceController::class, 'monCompte'])->name('agence.mon-compte');
});

// Routes pour l'authentification Visiteur (similaire à Agence)
Route::get('/visiteur/inscription', [VisiteurController::class, 'inscription'])->name('visiteur.inscription');
Route::post('/visiteur/inscription', [VisiteurController::class, 'enregistrerVisiteur']);
Route::get('/visiteur/inscription/confirmation', function () {
    return Inertia::render('Visiteur/InscriptionConfirmation');
})->name('visiteur.inscription.confirmation');
// Connexion visiteur
Route::get('/visiteur/connexion', [VisiteurController::class, 'seConnecterVisiteur'])->name('visiteur.connexion');
Route::post('/visiteur/connexion', [VisiteurController::class, 'authentifierVisiteur']);

// Route pour le formulaire de contact agence (sur la page de détail d'un bien)
Route::post('/biens/{bien:id}/contact', [VisiteurController::class, 'contacterAgence'])->name('biens.contact.agence');
Route::middleware(['auth:visiteur'])->group(function () {
    Route::get('/visiteur/mon-compte', [VisiteurController::class, 'monCompte'])->name('visiteur.mon-compte'); // Route protégée
    Route::post('/visiteur/deconnexion', [VisiteurController::class, 'deconnecterVisiteur'])->name('visiteur.deconnexion'); // Route protégée
});

// Controller test
Route::get('/test', [HomeController::class, 'test'])->name('test');
