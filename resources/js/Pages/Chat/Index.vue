<template>
<div class="container">
    <div class="card">
        <div class="card-header">Chats</div>
        <div class="card-body">
            <chat-messages :messages="messages"></chat-messages>
        </div>
        <div class="card-footer">
            <chat-form @messagesent="addMessage" :visiteur="$props.auth.visiteur" :room-id="roomId"></chat-form>
        </div>
    </div>
</div>
</template>
<script setup>
import VisitorLayout from '@/Layouts/VisitorLayout.vue';
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import ChatMessages from '@/Components/ChatMessages.vue';
import ChatForm from '@/Components/ChatForm.vue';
// Use visiror layout

const props = defineProps({
    auth: Object,
    visiteur: Object,
    messages: Array,
    roomId: String,
});

defineOptions({
  layout: VisitorLayout,
});

const messages = ref(props.messages); // Use ref to make messages reactive
// const roomId = ref(props.roomId); // REMOVE redundant ref
// console.log('roomId', roomId.value); // REMOVE redundant ref log

const fetchMessages = () => {
    axios.get('/messages').then(response => {
        messages.value = response.data; // Update the ref's value
        console.log('Fetch messages');
    });
};

const addMessage = (message) => {
    // messages.value.push(message); // Update the ref's value
    console.log('Add messages');
    axios.post('/messages', message).then(response => {
        console.log(response.data);
    });
};
onMounted(() => {
    fetchMessages();
    try {
        Echo.channel(`${props.roomId}`) // DYNAMIC CHANNEL NAME
            .listen('ChatMessageSent', (e) => {
                console.log('Ecouter sur message envoyé - Callback REACHED!');
                console.log('Event Data:', e);
                messages.value.push({
                    message: e.message.message,
                    sender_id: e.sender.id, // CORRECTED DATA ACCESS
                    sender: e.sender
                });
            });
    } catch (error) {
        console.error('Error setting up Echo listener:', error);
    }
});
</script>
