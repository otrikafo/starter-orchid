<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::routes(['middleware' => 'auth:visiteur']);

Broadcast::channel('chat-room', function ($user) { // Dynamic channel name with {roomId}
    return true; // TEMPORARY: Allow all for testing.  REVISE AUTHORIZATION LATER.
});
