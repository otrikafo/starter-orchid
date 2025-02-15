<template>
    <div class="chat-container">
        <div id="chat-messages" class="chat-messages-list">
            <div v-for="message in $props.messages" :key="message.id" class="chat-message">
                <span class="chat-message-user">{{ message.user ? message.user.name : 'Visiteur' }}</span>:
                <span class="chat-message-text">{{ message.message }}</span>
                <span class="chat-message-time">({{ formatTime(message.timestamp) }})</span>
            </div>
        </div>
        <form @submit.prevent="submit" class="contact-form">
            <div class="form-group">
                <label for="message" class="form-label">Votre message</label>
                <textarea
                id="message"
                v-model="form.newMessage"
                class="form-textarea"
                placeholder="Saisissez votre message ici..."
                ></textarea>
                <div v-if="form.errors.newMessage" class="error">{{ form.errors.newMessage }}</div>
            </div>
            <button type="submit" class="form-button":disabled="form.processing">
                Envoyer le message
            </button>
        </form>
  </div>
</template>

<script setup>
    // import { useForm } from '@inertiajs/vue3';
    // import { defineProps } from 'vue';
    // import Pusher from 'pusher-js';
    // import axios from 'axios';
    // console.log('ChatBox.vue');
    // const props = defineProps({
    //     agenceId: String, // Ajout de agenceId en props
    //     bienId: String,
    //     roomId: String,
    //     messages: Array
    // });
    // // Datas
    // const form = useForm({
    //     message: '',
    //     roomId: '',
    //     messages: [], // Tableau pour stocker les messages du chat
    //     newMessage: '', // Modèle pour le champ de saisie du message
    //     pusherChannel: null // Pour stocker l'instance du canal Pusher
    // });
    // console.log('props.room', props.roomId);


    // const submit = () => {
    //     console.log('submit');

    //     sendMessage(); // Appeler la méthode sendMessage pour envoyer le message
    // };

    // //  Mounted
    // const onMounted = (() => {
    //     setupPusher(); // Initialiser Pusher au montage du composant
    // });

    // // BeforeUnmount
    // const onBeforeUnmount = (() => {
    //     unsubscribePusher(); // Se désabonner de Pusher avant de détruire le composant
    // });

    // // Methods
    // const setupPusher = () => {
    //     const pusherAppKey = import.meta.env.VITE_PUSHER_APP_KEY; // Récupérer depuis les variables d'environnement Vite
    //     const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER;

    //     if (!pusherAppKey || !pusherCluster) {
    //         console.error('Clés Pusher non configurées dans .env (VITE_PUSHER_APP_KEY, VITE_PUSHER_APP_CLUSTER)');
    //         return;
    //     }

    //     const pusher = new Pusher(pusherAppKey, {
    //         cluster: pusherCluster,
    //         encrypted: true
    //     });

    //     form.pusherChannel = pusher.privateChannel(`${props.roomId}`); // Canal privé avec roomId dynamique

    //     form.pusherChannel.bind('message.sent', (data) => {
    //         form.messages.push(data); // Ajouter le nouveau message au tableau messages (réactivité Vue.js)
    //         $nextTick(() => { // S'assurer que le DOM est mis à jour avant de scroller
    //             scrollToBottom();
    //         });
    //     });

    //     // Gestion de l'autorisation pour les canaux privés (Inertia.js et route Laravel)
    //     Pusher.authorizer = (channel, options) => {
    //         return {
    //             authorize: (socketId, callback) => {
    //                 axios.post('/pusher/auth', { // Route Laravel pour l'autorisation Pusher
    //                     channel_name: channel.name,
    //                     socket_id: socketId
    //                 }, {
    //                     onSuccess: (page) => {
    //                         callback(null, page.props.auth); // Passer les données d'autorisation à Pusher
    //                     },
    //                     onError: (error) => {
    //                         callback(true, error); // Indiquer une erreur d'autorisation à Pusher
    //                     }
    //                 });
    //             }
    //         };
    //     };
    // };

    // const unsubscribePusher = () => {
    //     if (form.pusherChannel) {
    //         form.pusherChannel.unbind('message.sent'); // Se désabonner de l'événement
    //         form.pusherChannel.disconnect(); // Déconnecter du canal
    //         form.pusherChannel = null;
    //     }
    // };

    // const sendMessage = () => {
    //     const messageText = form.newMessage.trim();
    //     if (messageText !== '') {
    //         form.post('/send-message', { // Utiliser Inertia.post pour envoyer au backend Laravel
    //             message: messageText,
    //             roomId: props.roomId
    //         }, {
    //             onSuccess: () => {
    //                 form.newMessage = ''; // Vider le champ de saisie après l'envoi réussi
    //             },
    //             onError: (errors) => {
    //                 console.error('Erreur lors de l\'envoi du message:', errors); // Gérer les erreurs d'envoi
    //             }
    //         });
    //     }
    // };

    // const formatTime = (isoTime) => {
    //     if (!isoTime) return '';
    //     const date = new Date(isoTime);
    //     const hours = String(date.getHours()).padStart(2, '0');
    //     const minutes = String(date.getMinutes()).padStart(2, '0');
    //     return `<span class="math-inline">\{hours\}\:</span>{minutes}`;
    // };

    // const scrollToBottom = () => {
    //     const messageList = $el.querySelector('#chat-messages');
    //     if (messageList) {
    //         messageList.scrollTop = messageList.scrollHeight;
    //     }
    // };
</script>

<style scoped>
      .chat-container {  }
      .chat-messages-list {  }
      .chat-input-area {  }
      .chat-input-area input[type="text"] {  }
      .chat-input-area button {  }
      .chat-message {
          margin-bottom: 5px;
      }
      .chat-message-user {
          font-weight: bold;
          margin-right: 5px;
      }
      .chat-message-time {
          font-size: 0.8em;
          color: #777;
          margin-left: 5px;
      }
</style>
