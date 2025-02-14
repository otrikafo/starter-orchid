<template>
  <div>
    <h1>Bienvenue sur notre site immobilier</h1>
    <p>Découvrez nos dernières offres de biens immobiliers.</p>
    <Link :href="route('biens.index')">Voir les biens disponibles</Link>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue'; // Importez le layout

defineOptions({
  layout: VisitorLayout, // Définissez le layout à utiliser
});
</script>
