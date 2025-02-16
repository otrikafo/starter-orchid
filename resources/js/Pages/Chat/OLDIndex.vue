<template>
<div class="container">
    <div class="card">
        <div class="card-header">Chats</div>
        <div class="card-body" ref="chatBody" @scroll="handleScroll">
            <chat-messages :messages="messages"></chat-messages>
            <div v-if="loadingMoreMessages" class="loading-indicator">Chargement des messages...</div>
        </div>
        <div class="card-footer">
            <chat-form @messagesent="addMessage" :visiteur="$props.auth.visiteur" :room-id="roomId"></chat-form>
        </div>
    </div>
</div>
</template>

<script setup>
import VisitorLayout from '@/Layouts/VisitorLayout.vue';
import { ref, onMounted, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import ChatMessages from '@/Components/ChatMessages.vue';
import ChatForm from '@/Components/ChatForm.vue';

defineOptions({
  layout: VisitorLayout,
});

const props = defineProps({
    auth: Object,
    visiteur: Object,
    initialMessages: Array, // Renommer la prop messages en initialMessages pour clarifier
    roomId: String
});

const messages = ref(props.initialMessages); // Initialiser messages avec initialMessages
const roomId = ref(props.roomId);
const chatBody = ref(null); // Ref pour l'élément scrollable (card-body)
const loadingMoreMessages = ref(false); // Indicateur de chargement
const currentPage = ref(1); // Page actuelle
const allMessagesLoaded = ref(false); // Indique si tous les messages ont été chargés

const addMessage = (message) => {
    messages.value.push(message);
    axios.post('/messages', message).then(response => {
        console.log(response.data);
    });
};

const fetchMessages = (page) => {
    if (loadingMoreMessages.value || allMessagesLoaded.value) {
        return; // Ne pas charger si déjà en cours de chargement ou tous les messages chargés
    }
    loadingMoreMessages.value = true;
    axios.get('/messages', { params: { page: page } }).then(response => {
        loadingMoreMessages.value = false;
        if (response.data.length > 0) {
            // Ajouter les nouveaux messages *au début* du tableau pour l'infinite scroll vers le haut
            messages.value = [...response.data, ...messages.value];
            currentPage.value++;
        } else {
            allMessagesLoaded.value = true; // Marquer tous les messages comme chargés si le serveur ne retourne rien
            console.log('Tous les messages chargés');
        }
    });
};

const handleScroll = () => {
    if (allMessagesLoaded.value || loadingMoreMessages.value) return; // Ne rien faire si tous chargés ou en chargement

    const chatBodyElement = chatBody.value;
    if (chatBodyElement.scrollTop === 0) { // Détecter le scroll en haut
        console.log('Scroll en haut détecté, chargement des anciens messages...');
        fetchMessages(currentPage.value + 1); // Charger la page suivante
    }
};

onMounted(() => {
    // fetchMessages(1); // Chargement initial déplacé vers Inertia render pour éviter le flash de contenu
    try {
        Echo.channel(`chat-room`) // ou  Echo.private(`chat-room.${props.roomId}`) si roomId est dynamique
            .listen('ChatMessageSent', (e) => {
                console.log('Message reçu:', e);
                messages.value.push({
                    message: e.message.message,
                    sender_id: e.sender.id,
                    sender: e.sender,
                    isNew: true, // Marquer le message comme nouveau pour le style
                });
            });
    } catch (error) {
        console.error('Error setting up Echo listener:', error);
    }
});
</script>

<style scoped>
.card-body {
    height: 400px; /* Ajustez la hauteur selon vos besoins */
    overflow-y: scroll; /* Activer le scroll vertical */
    display: flex; /* Flexbox pour inverser le flux et scroller vers le haut */
    flex-direction: column-reverse; /* Messages récents en bas, anciens en haut */
}

.loading-indicator {
    text-align: center;
    padding: 10px;
    color: #777;
    font-size: 0.9em;
}
</style>
