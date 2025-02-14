<template>
  <div>
    <h1>Avis reçus par mon agence</h1>

    <div v-if="avisAgences.data.length > 0">
      <div v-for="avis in avisAgences.data" :key="avis.id" class="avis-card">
        <p>Note: {{ avis.note }}/5</p>
        <p>Commentaire: {{ avis.commentaire }}</p>
        <p>Visiteur: {{ avis.visiteur.email }}</p>
        <p>Date: {{ new Date(avis.created_at).toLocaleDateString() }}</p>
      </div>
    </div>
    <div v-else>
      <p>Aucun avis reçu pour le moment.</p>
    </div>

    <Pagination :links="avisAgences.links" />
  </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import AgenceLayout from '@/Layouts/AgenceLayout.vue';

defineOptions({
  layout: AgenceLayout,
});
const props = defineProps({
  avisAgences: Object,
});
</script>
