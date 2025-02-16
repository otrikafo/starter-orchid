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
  visiteur: Object,
  roomId: String,
});

const emit = defineEmits(['messagesent']); // Déclarer l'événement messagesent
const newMessage = ref('');
const visiteur = props.visiteur;
const roomId = props.roomId;
console.log('roomId', roomId);
const sendMessage = () => {
  if (newMessage.value) {
    emit('messagesent', { // **Émettre l'événement messagesent vers le parent**
      sender: visiteur,
      message: newMessage.value, // Modifier ici pour correspondre à l'attendu dans addMessage du parent
      roomId: roomId,
      sender_id: visiteur.id,
    });
    newMessage.value = '';
  }
};
</script>
