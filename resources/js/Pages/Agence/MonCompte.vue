<template>
  <div>
    <p v-if="$page.props.auth.agence">
      Bonjour, {{ $page.props.auth.agence.email }} ! Vous êtes connecté en tant que agence.
    </p>
    <p v-else>
      Vous n'êtes pas connecté en tant que agence.
    </p>

    <button v-if="!$page.props.auth.agence">
      <Link :href="route('agence.connexion')">Se connecter en tant que agence</Link>
    </button>
    <button v-else>
      <Link :href="route('agence.deconnexion')" method="post" as="button">Se déconnecter</Link>
    </button>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import AgenceLayout from '@/Layouts/AgenceLayout.vue';

defineOptions({
  layout: AgenceLayout,
});
</script>
