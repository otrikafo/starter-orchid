<template>
  <div class="visitor-layout">
    <header class="visitor-header">
      <nav class="visitor-nav">
        <div class="nav-left">
          <Link :href="route('home')" class="nav-brand">Site Immobilier</Link>
        </div>

        <div class="nav-right">
          <Link :href="route('biens.index')" class="nav-item">Biens</Link>
          <div class="nav-item has-submenu" @mouseover="showAgencesSubmenu = true" @mouseleave="showAgencesSubmenu = false">
            <span>Agences <i class="fas fa-caret-down submenu-arrow"></i></span>
            <div class="submenu" v-if="showAgencesSubmenu">
              <Link :href="route('agences.index')" class="submenu-item">Liste des Agences</Link>
              <Link v-if="!$page.props.auth.visiteur" :href="route('agence.inscription')" class="submenu-item">Devenir agence</Link>
            </div>
          </div>
          <Link :href="route('a-propos')" class="nav-item">À propos</Link>
          <Link :href="route('mentions-legales')" class="nav-item">Mentions Légales</Link>
          <Link :href="route('politique-confidentialite')" class="nav-item">Politique de Confidentialité</Link>
          <!-- Devenir agence -->
          <div class="mon-compte-menu">
            <span class="nav-item mon-compte-label">Mon compte</span>
            <div class="mon-compte-dropdown">
              <!-- Contextualiser les liens en fonction de l'état de l'utilisateur -->
              <Link v-if="$page.props.auth" :href="route('visiteur.connexion')" class="dropdown-item">Se connecter</Link>
              <Link v-if="$page.props.auth.agence" :href="route('agence.connexion')" class="dropdown-item">Espace agence</Link>
              <Link v-if="$page.props.auth.visiteur" :href="route('visiteur.deconnexion')" method="post" as="button" class="dropdown-item">Déconnexion</Link>
              <Link v-if="$page.props.auth.agence" :href="route('agence.deconnexion')" method="post" as="button" class="dropdown-item">Déconnexion</Link>
              <span v-if="$page.props.auth.visiteur" class="dropdown-item user-email">{{ $page.props.auth.visiteur.email }}</span>
            </div>
          </div>
        </div>
      </nav>
    </header>

    <main class="visitor-main">
      <slot />
    </main>

    <footer class="visitor-footer">
      <p>&copy; {{ new Date().getFullYear() }} Site Immobilier. Tous droits réservés.</p>
      <Link :href="route('mentions-legales')" class="footer-link">Mentions Légales</Link>
      <Link :href="route('politique-confidentialite')" class="footer-link">Politique de Confidentialité</Link>
    </footer>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'; // Import usePage

import { ref } from 'vue';
// import ChatBox from '@/Components/ChatBox.vue';

const showAgencesSubmenu = ref(false);
</script>

<style scoped>
.visitor-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.visitor-header {
  background-color: #f8f9fa;
  padding: 15px 0;
  border-bottom: 1px solid #eee;
}

.visitor-nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
  max-width: 1200px;
  margin: 0 auto;
}

.nav-brand {
  font-size: 1.5em;
  font-weight: bold;
  color: #333;
  text-decoration: none;
}

.nav-right {
  display: flex;
  align-items: center;
}

.nav-item {
  color: #555;
  text-decoration: none;
  margin-left: 20px;
  padding: 5px 10px;
  border-radius: 5px;
}

.nav-item:hover {
  background-color: #eee;
}

.mon-compte-menu {
  position: relative;
  margin-left: 20px;
}

.mon-compte-label {
  cursor: pointer;
  color: #555;
  padding: 5px 10px;
  border-radius: 5px;
}

.mon-compte-label:hover {
  background-color: #eee;
}

.mon-compte-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  background-color: white;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px 0;
  width: 180px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  display: none; /* Initialement caché */
}

.mon-compte-menu:hover .mon-compte-dropdown {
  display: block; /* Afficher au survol */
}

.dropdown-item {
  display: block;
  padding: 8px 15px;
  color: #333;
  text-decoration: none;
}

.dropdown-item:hover {
  background-color: #f0f0f0;
}

.user-email {
  display: block;
  padding: 8px 15px;
  color: #777;
  font-size: 0.9em;
}


.visitor-main {
  flex: 1;
  padding: 20px;
  max-width: 1200px;
  margin: 0 10%;
}

.visitor-footer {
  background-color: #f8f9fa;
  padding: 20px 0;
  border-top: 1px solid #eee;
  text-align: center;
  font-size: 0.9em;
  color: #777;
}

.footer-link {
  color: #777;
  text-decoration: none;
  margin: 0 10px;
}

.footer-link:hover {
  text-decoration: underline;
}

/* Styles pour le submenu */
.nav-item.has-submenu {
  position: relative; /* Important pour positionner le submenu */
  cursor: pointer;
}

.nav-item.has-submenu span {
    display: flex; /* Pour aligner le texte et la flèche */
    align-items: center;
}

.submenu-arrow {
    margin-left: 5px;
    font-size: 0.8em;
}


.submenu {
  position: absolute;
  top: 100%; /* Position sous l'élément parent */
  left: 0;
  background-color: #fff;
  border: 1px solid #ddd;
  border-top: none;
  border-radius: 0 0 5px 5px;
  padding: 5px 0;
  width: 200px; /* Ajustez la largeur du submenu */
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  z-index: 10; /* Pour être au-dessus des autres éléments */
}

.submenu-item {
  display: block;
  padding: 10px 20px;
  color: #555;
  text-decoration: none;
  transition: background-color 0.2s ease, color 0.2s ease;
}

.submenu-item:hover {
  background-color: #f0f0f0;
  color: #333;
}

</style>
