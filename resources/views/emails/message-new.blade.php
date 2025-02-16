@extends('emails.general-email-template')
@section('title', 'Vous avez reçu un nouveau chat')
@section('title_header') Vous avez reçu un nouveau chat
@endsection

@section('content')
<h1>Bonjour {{ $receiverName }}!</h1>
<p>Vous avez reçu un chat de , {{ $sender->email }}!</p>
<p>Message: {{ $message->message }}</p>
<p>
    <!-- Lien voir le message -->
    <a href="{{ route('chat.show', $room->id) }}" class="btn btn-primary">Voir le message</a>
</p>
@endsection