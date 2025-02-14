@extends('emails.general-email-template') @section('title', 'Nouvelle inscription visiteur sur le site immobilier') @section('title_header') Nouvelle inscription visiteur sur le site immobilier
@endsection

@section('content')
<p>Un nouveau visiteur s'est inscrit sur le site :</p>
<ul>
    <li>Email du visiteur: {{ $visiteur->email }}</li>
    <li>Date d'inscription: {{ $visiteur->created_at }}</li>
</ul>
<p>Veuillez vérifier les inscriptions et prendre les mesures nécessaires si besoin.</p>
@endsection