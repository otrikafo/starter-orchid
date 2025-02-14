@extends('emails.general-email-template') @section('title', 'Inscription réussie sur notre site immobilier') @section('title_header') Inscription réussie sur notre site immobilier
@endsection

@section('content')
<h1>Bienvenue sur notre site immobilier, {{ $visiteur->email }}!</h1>
<p>Votre inscription a bien été prise en compte.</p>
<p>Vous pouvez maintenant vous connecter à votre compte visiteur pour profiter de toutes les fonctionnalités de notre site.</p>
<p>Merci de votre inscription !</p>
@endsection