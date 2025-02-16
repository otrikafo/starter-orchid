<template>
  <ul class="chat" v-if="messages.length > 0">
    <li class="left clearfix" v-for="message in messages" :key="message.id">
        <!-- Mettre une classe en fonction de isNew pour contextualiser -->
      <div class="chat-body clearfix" :class="{ 'new': message.isNew, 'chat-sent-by-me': (props.sender && props.sender.id === message.sender_id)}" >
        <div class="header">
          <strong>
            {{ message.sender.email }}
            <span class="time-ago">{{ message.timestamp }}</span>
          </strong>
        </div>
        <p>
          {{ message.message }}
        </p>
        <!-- Date de création -->
        <div>
            <small class="text-muted">
                {{ message.created_at }}
            </small>
        </div>
      </div>
    </li>
  </ul>
</template>

<script setup>

const props = defineProps({
  messages: Object,
  sender: String, // Accepter la prop roomId
});
console.log(props);
const isMyMessage = (senderId) => {
    return props.sender && props.sender.id === senderId;
};

</script>

<style scoped>
.chat {
  list-style: none;
  margin: 0;
  padding: 0;
}

.chat li {
  margin-bottom: 10px;
  padding: 10px;
  overflow: hidden;
  display: flex; /* Utiliser Flexbox pour aligner le contenu */
  flex-direction: column; /* Organiser header et paragraphe en colonne */
}

.chat .left {
  background-color: #f8f8f8; /* Couleur pour les messages reçus (ou les vôtres) */
  border-radius: 5px;
  align-self: flex-start; /* Aligner à gauche */
}


.chat .header {
  font-size: 0.9em;
  color: #777;
  margin-bottom: 5px;
  display: flex; /* Flexbox pour aligner nom et timestamp */
  justify-content: space-between; /* Espacer nom et timestamp */
}

.chat .header strong {
  font-weight: bold;
  margin-right: 10px; /* Espacement entre le nom et le timestamp */
}

.chat .header .time-ago {
  font-size: 0.8em;
  color: #999;
  font-style: italic;
}

.chat p {
  margin: 0;
  word-wrap: break-word; /* Gérer les longs messages */
}
.chat .new {
  background-color: #e6f7ff; /* Couleur pour les nouveaux messages */
}

.chat-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 10px 0; /* Ajout de padding vertical pour espacer les messages du bord du container */
}

.chat-body {
    padding: 10px 15px;
    border-radius: 10px;
    background-color: #f0f0f0; /* Couleur de fond par défaut (gris clair) */
    position: relative; /* Pour positionner pseudo-éléments si besoin */
    word-wrap: break-word; /* Permettre aux longs mots de passer à la ligne */
    padding: 5px;
    border-radius: 10px;
}

.chat-sent-by-me {
    background-color:#007bffe0; /* Fond bleu pour mes messages */
    color: white; /* Texte blanc pour mes messages */
    align-self: flex-end; /* Aligner mes messages à droite */
}
.chat-sent-by-me .header {
  color: #f5f2f2;
}

.chat-content {
    font-size: 0.95em; /* Taille de police légèrement réduite pour les messages */
}
</style>
