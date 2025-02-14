@extends('emails.general-email-template') @section('title', 'Agence Registered Mail') @section('title_header') Agence Registered Mail
@endsection

@section('content')
<h1>Bienvenue sur notre site immobilier, {{ $agence->email }}!</h1>
<p>Votre inscription a bien été prise en compte.</p>
<p>Vous pouvez maintenant vous connecter à votre compte agence pour profiter de toutes les fonctionnalités de notre site.</p>
<p>Merci de votre inscription !</p>
@endsection