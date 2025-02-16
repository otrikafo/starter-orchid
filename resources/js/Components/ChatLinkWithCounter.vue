<template>
    <Link :href="chatRoute" class="chat-link-with-counter">
        <slot>Chat Privé</slot>  <span v-if="messageCount > 0" class="message-counter">
            {{ messageCount }}
        </span>
    </Link>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    chatRoute: {
        type: String,
        required: true,
    },
    messageCount: {
        type: Number,
        default: 0,
    },
});
</script>

<style scoped>
.chat-link-with-counter {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    color: #333; /* Couleur du lien par défaut */
    transition: color 0.3s ease;
    padding: 8px 12px;
    border-radius: 5px;
    background-color: transparent; /* Fond transparent par défaut */
}

.chat-link-with-counter:hover {
    color: #007bff; /* Couleur au survol */
    background-color: #f0f0f0; /* Fond gris clair au survol */
}

.message-counter {
    display: inline-block;
    background-color: #dc3545; /* Rouge pour le compteur de messages */
    color: white;
    font-size: 0.8em;
    border-radius: 50%; /* Forme de badge rond */
    padding: 4px 8px;
    margin-left: 8px;
    line-height: 1; /* Ajuster la hauteur de ligne pour centrer verticalement */
    text-align: center;
    vertical-align: middle;
}
</style>
