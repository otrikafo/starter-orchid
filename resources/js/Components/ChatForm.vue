<template>
  <div class="input-group">
    <input
      type="text"
      class="form-control"
      placeholder="Entrez votre message..."
      v-model="newMessage"
      @keyup.enter="sendMessage"
    />
    <div class="input-group-append">
      <button
        class="btn btn-primary"
        @click="sendMessage"
        :disabled="!newMessage"
      >
        Envoyer
      </button>
    </div>
  </div>
</template>
<script setup>
import { ref, defineEmits } from 'vue';

const props = defineProps({
  sender: Object,
  roomId: String, // Accepter la prop roomId
});

const emit = defineEmits(['messagesent']);
const newMessage = ref('');
const sender = props.sender;
const roomId = props.roomId; // Récupérer roomId depuis les props
console.log('roomId in ChatForm', roomId);
console.log(sender);
const sendMessage = () => {
  if (newMessage.value) {
    emit('messagesent', {
      sender: sender,
      message: newMessage.value,
      roomId: roomId, // Inclure roomId dans l'événement
      sender_id: sender.id,
    });
    newMessage.value = '';
  }
};
</script>
