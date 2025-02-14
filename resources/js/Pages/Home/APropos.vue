<template>
  <div>
    <h1>À Propos</h1>
    <p>Page "À propos" de votre site immobilier.</p>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue'; // Importez le layout

defineOptions({
  layout: VisitorLayout, // Définissez le layout à utiliser
});
</script>
