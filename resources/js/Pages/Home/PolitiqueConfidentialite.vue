<template>
  <div>
    <h1>Politique de Confidentialité</h1>
    <p>Page "Politique de Confidentialité" de votre site immobilier.</p>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue'; // Importez le layout

defineOptions({
  layout: VisitorLayout, // Définissez le layout à utiliser
});
</script>
