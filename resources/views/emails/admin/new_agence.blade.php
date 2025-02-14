@extends('emails.general-email-template') @section('title', 'Nouvelle inscription agence sur le site immobilier') @section('title_header') Nouvelle inscription agence sur le site immobilier
@endsection

@section('content')
<p>Un nouveau agence s'est inscrit sur le site :</p>
<ul>
    <li>Email du agence: {{ $agence->email }}</li>
    <li>Date d'inscription: {{ $agence->created_at }}</li>
</ul>
<p>Veuillez vérifier les inscriptions et prendre les mesures nécessaires si besoin.</p>
@endsection