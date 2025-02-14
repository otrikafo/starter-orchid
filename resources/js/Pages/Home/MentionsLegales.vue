<template>
  <div>
    <h1>Mentions Légales</h1>
    <p>Page "Mentions Légales" de votre site immobilier.</p>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue'; // Importez le layout

defineOptions({
  layout: VisitorLayout, // Définissez le layout à utiliser
});
</script>
