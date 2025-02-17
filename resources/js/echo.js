import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    namespace: 'App.Events',
});

// const beamsClient = new PusherPushNotifications.Client({
//     instanceId: '6fca8bea-937c-4c14-9eea-c5c9e564d91b',
// });

// beamsClient.start()
//     .then(() => beamsClient.addDeviceInterest('debug-hello'))
//     .then(() => console.log('Successfully registered and subscribed!'))
//     .catch(console.error);

