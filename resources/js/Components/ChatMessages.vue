<template>
  <ul class="chat" v-if="messages.length > 0">
    <li class="left clearfix" v-for="message in messages" :key="message.id">
      <div class="clearfix">
        <div class="header">
          <strong>
            {{ message.sender.nom }}
            <span class="time-ago">{{ message.timestamp }}</span>
          </strong>
        </div>
        <p>
          {{ message.message }}
        </p>
      </div>
    </li>
  </ul>
</template>

<script>

export default {
  props: ["messages"]
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
</style>
