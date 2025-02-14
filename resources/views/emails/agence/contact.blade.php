@extends('emails.general-email-template') @section('title', 'Demande de contact pour un bien immobilier') @section('title_header') Demande de contact pour le bien "{{ $bien->titre }}"
@endsection

@section('content') <p>Bonjour {{ $agence->raison_sociale }},</p>

<p>Un visiteur, <strong>{{ $visiteur->nom }}</strong>, a exprimé son intérêt pour le bien immobilier suivant :</p>

<h2>Détails du bien :</h2>
<ul>
    <li><strong>Titre :</strong> {{ $bien->titre }}</li>
    <li><strong>Ville :</strong> {{ $bien->ville }}</li>
    <li><strong>Adresse :</strong> {{ $bien->adresse }}</li>
    <li><strong>Prix :</strong> {{ $bien->prix }} €</li>
    <li><strong>Type de transaction :</strong> {{ $bien->type_transaction === 'vente' ? 'Vente' : 'Location' }}</li>
    <li>
        <a href="{{ route('biens.show', ['bien' => $bien->id]) }}" class="button">Voir le détail du bien en ligne</a>
    </li>
</ul>

<h2>Informations du visiteur :</h2>
<ul>
    <li><strong>Nom du visiteur :</strong> {{ $visiteur->nom }}</li>
    <li><strong>Adresse e-mail du visiteur :</strong> {{ $visiteur->email }}</li>
</ul>

<p>Veuillez contacter ce visiteur dans les plus brefs délais pour répondre à sa demande.</p>
@endsection