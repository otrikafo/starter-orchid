<template>
    <VisitorLayout>
        <div class="container-grid">
            <aside class="chat-list-panel">
                <h2>Mes Chats Privés</h2>
                <div v-if="rooms && rooms.length > 0" class="rooms-list">
                    <div v-for="room in rooms" :key="room.id" class="room-card"
                         :class="{ 'selected': selectedRoomId === room.id }"
                         @click="selectRoom(room)">
                        <div class="room-header">
                            <h3 class="agence-name" v-if="room.agence">{{ room.agence.raison_sociale }}</h3>
                            <p class="no-agence-name" v-else>Agence Inconnue</p>
                        </div>
                        <div class="room-details">
                            <p class="last-message" v-if="room.messages && room.messages.length > 0">
                                Dernier message: "{{ room.messages[room.messages.length - 1].message }}"
                            </p>
                            <p class="no-messages" v-else>Aucun message dans cette salle.</p>
                        </div>
                        <div>
                            <Link :href="`/agence/chat/${room.id}`">Ouvrir</Link>
                        </div>
                    </div>
                </div>
                <div v-else class="no-rooms">
                    <p>Vous n'avez pas encore de chats privés. Démarrez une conversation depuis la page d'une agence.</p>
                </div>
            </aside>

            <main class="message-panel">
                <div v-if="selectedRoomId" class="chat-area">
                    <div class="card">
                        <div class="card-header">
                            Chat avec
                            <span v-if="selectedRoom && selectedRoom.agence">{{ selectedRoom.agence.raison_sociale }}</span>
                            <span v-else>Agence Inconnue</span>
                        </div>
                        <div class="card-body" ref="chatBody" @scroll="handleScroll">
                            <chat-messages :messages="messages" :sender="sender"></chat-messages>
                            <div v-if="loadingMoreMessages" class="loading-indicator">Chargement des messages...</div>
                        </div>
                        <div class="card-footer">
                            <chat-form @messagesent="addMessage" :sender="$props.sender" :room-id="selectedRoomId"></chat-form>
                        </div>
                    </div>
                </div>
                <div v-else class="no-chat-selected">
                    <p>Sélectionnez une conversation à gauche pour afficher les messages.</p>
                </div>
            </main>
        </div>
    </VisitorLayout>
</template>

<script setup>
import { defineProps, ref, onMounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import ChatMessages from '@/Components/ChatMessages.vue';
import ChatForm from '@/Components/ChatForm.vue';
import AgenceLayout from '@/Layouts/AgenceLayout.vue';

defineOptions({
  layout: AgenceLayout,
});
const props = defineProps({
    rooms: Array,
    sender: Object,
    initialMessages: Array, // Initial messages prop is no longer directly used for all messages
});

const rooms = ref(props.rooms);
const sender = ref(props.sender);
const messages = ref([]); // Messages are now loaded per selected room
const chatBody = ref(null);
const loadingMoreMessages = ref(false);
const currentPage = ref(1);
const allMessagesLoaded = ref(false);
const selectedRoomId = ref(null); // Reactive ref to store the selected room ID
const selectedRoom = ref(null); // Reactive ref to store the selected room object

const selectRoom = (room) => {
    selectedRoomId.value = room.id;
    selectedRoom.value = room; // Store the selected room object
    messages.value = []; // Clear previous messages
    currentPage.value = 1;
    allMessagesLoaded.value = false;
    fetchMessages(1, room.id); // Load messages for the selected room
    setupEchoListener(room.id); // Setup Echo listener for the selected room
};

const addMessage = (message) => {
    // messages.value.push(message);
    axios.post('/agence/messages', { ...message, roomId: selectedRoomId.value }).then(response => {
        console.log(response.data);
    });
};

const fetchMessages = (page, roomId) => {
    if (loadingMoreMessages.value || allMessagesLoaded.value || !roomId) {
        return;
    }
    loadingMoreMessages.value = true;
    axios.get('/agence/messages', { params: { page: page, roomId: roomId } }).then(response => {
        loadingMoreMessages.value = false;
        if (response.data.length > 0) {
            messages.value = [...response.data, ...messages.value];
            currentPage.value++;
        } else {
            allMessagesLoaded.value = true;
            console.log('Tous les messages chargés pour cette salle');
        }
    });
};

const handleScroll = () => {
    if (allMessagesLoaded.value || loadingMoreMessages.value || !selectedRoomId.value) return;

    const chatBodyElement = chatBody.value;
    if ((chatBodyElement.scrollHeight + chatBodyElement.scrollTop) < 560) {
        console.log('Scroll en haut détecté, chargement des anciens messages...');
        fetchMessages(currentPage.value + 1, selectedRoomId.value);
    }
};

const setupEchoListener = (roomId) => {
    if (window.Echo) {
        window.Echo.leaveChannel(`chat-room.${selectedRoomId.value}`); // Leave previous channel if any
    }
    try {
        console.log('Setting up Echo listener for room:', `chat-room.${roomId}`);

        window.Echo.channel(`chat-room.${roomId}`)
            .listen('ChatMessageSent', (e) => {
                    console.log('Received message:', e.message.message, 'for room:', e.roomId);
                if (e.roomId === selectedRoomId.value) {
                     // Check if message is for the currently selected room
                    messages.value.push({
                        message: e.message.message,
                        sender_id: e.sender.id,
                        sender: e.sender,
                    });
                    // Mettre  à jour le premier message dans room.messages
                    const roomIndex = rooms.value.findIndex(room => room.id === e.roomId);
                    if (roomIndex > -1) {
                        rooms.value[roomIndex].messages = [e.message];
                    }
                }
            });
    } catch (error) {
        console.error('Error setting up Echo listener:', error);
    }
};


onMounted(() => {
    if (props.rooms && props.rooms.length > 0) {
        // Select the first room by default or leave it empty initially
        selectRoom(props.rooms[0]); // Uncomment this line to select the first room on load
    }
});
</script>

<style scoped>
.container-grid {
    display: grid;
    grid-template-columns: 300px 1fr; /* Left panel 300px, right panel takes remaining space */
    gap: 0; /* No gap between panels */
    height: 80vh; /* Adjust as needed */
    max-width: 1200px;
    margin: 20px auto;
    background-color: #f8f8f8;
    border-radius: 8px;
    overflow: hidden; /* Ensure rounded corners are respected */
}

.chat-list-panel {
    background-color: #f0f0f0;
    border-right: 1px solid #ddd;
    padding: 20px;
    overflow-y: auto; /* Make scrollable if rooms list is long */
    height: 100%; /* Fill the height of the container-grid */
}

.chat-list-panel h2 {
    color: #333;
    margin-bottom: 15px;
    text-align: center;
}

.rooms-list {
    display: flex;
    flex-direction: column; /* List rooms vertically */
    gap: 10px;
}

.room-card {
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 15px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    border: 2px solid transparent; /* For selected state border */
}

.room-card.selected {
    background-color: #e9ecef; /* Highlight selected room */
    border-color: #007bff; /* Highlight selected room border */
}


.room-card:hover {
    background-color: #f9f9f9;
}

.room-header {
    margin-bottom: 10px;
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
}

.agence-name {
    font-size: 1em;
    color: #007bff;
    margin-top: 0;
    margin-bottom: 0;
}

.no-agence-name {
    font-style: italic;
    color: #777;
    font-size: 0.9em;
    margin-top: 0;
    margin-bottom: 0;
}


.room-details {
    /* Styles for room details if needed */
}

.last-message, .no-messages {
    font-size: 0.85em;
    color: #666;
    margin-top: 2px;
    margin-bottom: 2px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; /* Prevent wrapping */
    max-width: 100%; /* Ensure it doesn't overflow room card */
}
.no-messages {
    font-style: italic;
}


.message-panel {
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Keep chat form at bottom */
    height: 100%; /* Fill the height of the container-grid */
}

.chat-area {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card {
    display: flex;
    flex-direction: column;
    height: 100%; /* Card takes full height of message panel */
    border: none;
    box-shadow: none; /* Remove card shadow if desired */
}


.card-header {
    background-color: #fff;
    padding: 15px;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
    color: #333;
    border-top-left-radius: 0; /* Remove card header rounded corners to align with panel */
    border-top-right-radius: 0;
}

.card-body {
    flex-grow: 1; /* Card body takes up remaining space */
    overflow-y: scroll;
    padding: 20px;
    display: flex;
    flex-direction: column-reverse; /* Messages from bottom to top */
    background-color: #fff;
    height: 500px;
}

.card-footer {
    background-color: #fff;
    padding: 15px;
    border-top: 1px solid #ddd;
    border-bottom-left-radius: 0; /* Remove card footer rounded corners to align with panel */
    border-bottom-right-radius: 0;
}


.loading-indicator {
    text-align: center;
    padding: 10px;
    color: #777;
    font-size: 0.9em;
}

.no-chat-selected {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #777;
    font-style: italic;
    text-align: center;
}
</style>
