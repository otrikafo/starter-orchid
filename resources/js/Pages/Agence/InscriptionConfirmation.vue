<template>
  <div>
    <h1>Inscription Réussie !</h1>
    <p>Votre demande d'inscription a bien été enregistrée. Elle est en cours de validation par l'administrateur.</p>
    <p>Vous recevrez un email de confirmation une fois votre compte validé.</p>
  </div>
</template>

<script setup>
import AgenceLayout from '@/Layouts/AgenceLayout.vue';

defineOptions({
  layout: AgenceLayout,
});
</script>
