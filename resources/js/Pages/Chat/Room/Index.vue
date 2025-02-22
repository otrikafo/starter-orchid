<template>
<div class="container">
    <div class="card">
        <div class="card-header">Chats Privés ( {{ room.agence.raison_sociale }})</div>
        <div class="card-body" ref="chatBody" @scroll="handleScroll">
            <chat-messages :messages="messages" :sender="sender"></chat-messages>
            <div v-if="loadingMoreMessages" class="loading-indicator">Chargement des messages...</div>
        </div>
        <div class="card-footer">
            <chat-form @messagesent="addMessage" :sender="$props.sender" :room-id="roomId"></chat-form>
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
    sender: Object,
    initialMessages: Array,
    roomId: String, // Récupérer roomId comme prop,
    room: Object,
});

const messages = ref(props.initialMessages);
const roomId = ref(props.roomId); // Conserver roomId dans un ref
const chatBody = ref(null);
const loadingMoreMessages = ref(false);
const currentPage = ref(1);
const allMessagesLoaded = ref(false);

const addMessage = (message) => {
    // messages.value.push(message);
    axios.post('/messages', { ...message, roomId: roomId.value }).then(response => { // Envoyer roomId au backend
        console.log(response.data);
    });
};

const fetchMessages = (page) => {
    if (loadingMoreMessages.value || allMessagesLoaded.value) {
        return;
    }
    loadingMoreMessages.value = true;
    axios.get('/messages', { params: { page: page, roomId: roomId.value } }).then(response => { // Envoyer roomId au backend
        loadingMoreMessages.value = false;
        if (response.data.length > 0) {
            messages.value = [...response.data, ...messages.value];
            currentPage.value++;
        } else {
            allMessagesLoaded.value = true;
            console.log('Tous les messages chargés');
        }
    });
};

const handleScroll = () => {
    if (allMessagesLoaded.value || loadingMoreMessages.value) return;

    const chatBodyElement = chatBody.value;
    if (chatBodyElement.scrollTop === 0) {
        console.log('Scroll en haut détecté, chargement des anciens messages...');
        fetchMessages(currentPage.value + 1);
    }
};

onMounted(() => {
    fetchMessages(1); // Charger les messages initiaux au montage
    try {
        Echo.channel(`chat-room.${roomId.value}`)
            .subscribed(function(){
                console.log('subscribed To Channel')
            })
            .listenToAll(function(){
                console.log('listening to channel')
            })
            .listen('ChatMessageSent', (e) => {
                messages.value.push({
                    message: e.message.message,
                    sender_id: e.sender.id,
                    sender: e.sender,
                });
            });
    } catch (error) {
        console.error('Error setting up Echo listener:', error);
    }
});
</script>

<style scoped>
.card-body {
    height: 400px;
    overflow-y: scroll;
    display: flex;
    flex-direction: column-reverse;
}

.loading-indicator {
    text-align: center;
    padding: 10px;
    color: #777;
    font-size: 0.9em;
}
</style>
