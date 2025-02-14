<template>
  <div>
    <p v-if="$page.props.auth.visiteur">
      Bonjour, {{ $page.props.auth.visiteur.email }} ! Vous êtes connecté en tant que visiteur.
    </p>
    <p v-else>
      Vous n'êtes pas connecté en tant que visiteur.
    </p>

    <button v-if="!$page.props.auth.visiteur">
      <Link :href="route('visiteur.connexion')">Se connecter en tant que visiteur</Link>
    </button>
    <button v-else>
      <Link :href="route('visiteur.deconnexion')" method="post" as="button">Se déconnecter</Link>
    </button>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue';

defineOptions({
  layout: VisitorLayout,
});
</script>
