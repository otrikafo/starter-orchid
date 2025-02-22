<template>
  <div class="agence-layout">
    <header class="agence-header">
    <div class="header-content">
      <div class="header-left">
        <Link :href="route('home')" class="logo-link">
          <img src="/logo.svg" alt="Logo de l'Agence" class="agence-logo" />
        </Link>
        <span class="agence-brand">Espace Agence</span>

      </div>
      <div class="header-right">
      </div>
        <div class="hamburger-icon" :class="{ open: isSidebarOpen }" @click="toggleSidebar">
            <span class="line line1"></span>
            <span class="line line2"></span>
            <span class="line line3"></span>
        </div>
    </div>
  </header>

    <div class="container">
        <aside class="agence-sidebar" :class="{ 'sidebar-open': isSidebarOpen }">  <nav class="sidebar-nav">
                <div class="user-info">
                    <span class="user-icon">👤</span>
                    <span class="user-name" v-if="$page.props.auth.agence">{{ $page.props.auth.agence.raison_sociale }}</span>
                </div>
                <Link v-if="$page.props.auth.agence" :href="route('agence.dashboard')" class="sidebar-item":class="{ active: $page.url === route().current('agence.dashboard') }">
                <i class="fas fa-chart-line sidebar-icon"></i> Dashboard
                </Link>
                <Link v-if="$page.props.auth.agence" :href="route('agence.biens.index')" class="sidebar-item":class="{ active: $page.url.startsWith(route('agence.biens.index')) }">
                <i class="fas fa-home sidebar-icon"></i> Biens
                </Link>

                <Link v-if="$page.props.auth.agence" :href="route('agence.mon-compte')" class="sidebar-item":class="{ active: $page.url === route().current('agence.mon-compte') }">
                <i class="fas fa-user-cog sidebar-icon"></i> Mon Profil
                </Link>
                <Link v-if="$page.props.auth.agence" :href="route('agence.chat.index')" class="sidebar-item":class="{ active: $page.url === route().current('agence.chat.index') }">
                <i class="fas fa-comments sidebar-icon"></i> Chat
                </Link>
                <Link v-if="$page.props.auth.agence" :href="route('agence.deconnexion')" method="post" as="button" class="dropdown-item">
                    <i class="fas fa-user-cog logout-button"></i>
                    Déconnexion
                </Link>
            </nav>
        </aside>
            <main class="agence-main">
                <VisitorBreadcrumbs :breadcrumbs="pageBreadcrumbs" />
                <slot />
            </main>
    </div>

    <footer class="agence-footer">
      <p>&copy; {{ new Date().getFullYear() }} Espace Agence. Tous droits réservés.</p>
    </footer>
  </div>
</template>

<script setup>
import { Link,  usePage} from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import VisitorBreadcrumbs from '@/Components/VisitorBreadcrumbs.vue'; // Importez le composant
const page = usePage();

const pageBreadcrumbs = computed(() => {
    return page.props.breadcrumbs || []; // Récupérez les breadcrumbs depuis les props de la page Inertia
});

const isSidebarOpen = ref(false); // Nouvel état pour la sidebar mobile (fermée par défaut)

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value; // Basculer l'état de la sidebar mobile
};
</script>

<style scoped>.agence-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh; /* Assure que le layout prend au moins 100% de la hauteur de la fenêtre */
  justify-content: space-between; /* Ajout de justify-content: space-between */
}.agence-brand {
  font-size: 1.8em;
  font-weight: bold;
}.header-right {
  display: flex;
  align-items: center;
}.user-info {
  display: flex;
  align-items: center;
}.user-name {
  margin-right: 20px;
  font-weight: bold;
}.logout-button {
  background-color: #dc3545; /* Rouge pour la déconnexion */
  color: white;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none;
}.logout-button:hover {
  background-color: #c82333;
}
.agence-sidebar {
  width: 250px; /* Sidebar fixe */
  background-color: #212529; /* Couleur foncée pour la sidebar */
  color: white;
  padding-top: 20px;
  height: 100vh; /* Sidebar pleine hauteur */
  position: sticky; /* Sidebar fixe au scroll */
  top: 0;
}.sidebar-nav {
  padding: 0 20px;
}.sidebar-item {
  display: block;
  padding: 10px 15px;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  margin-bottom: 8px;
  transition: background-color 0.2s ease;
  display: flex; /* Pour aligner icône et texte */
  align-items: center;
}.sidebar-item:hover,.sidebar-item.active {
  background-color: #495057; /* Couleur plus claire au survol/actif */
}.sidebar-icon {
  margin-right: 10px; /* Espace entre l'icône et le texte */
  font-size: 1.2em; /* Taille des icônes */
}.agence-main {
  flex: 1; /* Main content prend l'espace restant */
  padding: 20px;
  background-color: #f0f2f5; /* Couleur de fond claire pour le contenu principal */
}.agence-footer {
  background-color: #343a40;
  color: white;
  text-align: center;
  padding: 10px 0;
  font-size: 0.9em;
  border-top: 1px solid #495057;
}
.container {
  display: flex;
  /* max-width: 1200px; */
}

/* /header */
.agence-header {
  background-color: #f8f9fa; /* Light background color */
  padding: 15px 20px;
  border-bottom: 1px solid #eee;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.header-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px; /* Adjust as needed for your layout */
  margin: 0 auto;
}

.header-left {
  display: flex;
  align-items: center;
}

.logo-link {
  display: block; /* Make logo link area clickable */
}

.agence-logo {
  height: 40px; /* Adjust logo size as needed */
  margin-right: 10px;
  transition: transform 0.2s ease-in-out; /* Hover effect */
}

.agence-logo:hover {
  transform: scale(1.1);
}


.agence-brand {
  font-size: 1.5em; /* Slightly larger brand name */
  font-weight: bold;
  color: #333; /* Darker brand color */
  margin-right: 5px;
}

.user-icon {
  font-size: 1.2em;
  color: #777; /* Muted user icon color */
}


.header-right {
  display: flex;
  align-items: center;
}

.user-info {
  display: flex;
  align-items: center;
}

.user-name {
  margin-right: 20px;
  color: #555; /* User name color */
}

.logout-button {
  background-color: #dc3545; /* Red logout button */
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1em;
  text-decoration: none; /* Remove underline from Link */
  transition: background-color 0.2s ease;
}

.logout-button:hover {
  background-color: #c82333; /* Darker red on hover */
}
/* ... Vos styles CSS existants pour AgenceLayout.vue (à coller ici) ... */

/* Media Queries pour Responsive Design - Sidebar Collapsible */

@media (max-width: 768px) { /* Styles pour les écrans de tablette et mobiles */
    .container {
        flex-direction: column; /* Container en colonne sur mobile (sidebar au-dessus ou cachée) */
    }

    .agence-sidebar {
        position: fixed; /* Sidebar en position fixed pour l'overlay ou absolute si push */
        top: 0;
        left: 0;
        height: 100%; /* Pleine hauteur de la fenêtre */
        width: 250px; /* Garder la largeur de la sidebar (ou ajuster) */
        z-index: 100; /* Pour être au-dessus du contenu */
        transform: translateX(-250px); /* Cacher la sidebar par défaut en la déplaçant hors écran à gauche */
        transition: transform 0.3s ease; /* Animation pour l'ouverture/fermeture */
        padding-top: 60px; /* Espace pour le header fixe */
        overflow-y: auto; /* Permettre le scroll si le contenu de la sidebar est trop long */
    }
    .agence-sidebar.sidebar-open { /* Classe pour afficher la sidebar mobile */
        transform: translateX(0); /* Afficher la sidebar en la ramenant dans l'écran */
    }

    .agence-main {
        padding-top: 20px; /* Ajuster le padding du contenu principal pour mobile */
        padding-bottom: 20px;
        padding-left: 15px;
        padding-right: 15px;
    }

    /* Ajuster le header pour mobile - optionnel, peut-être juste réduire le padding */
    .agence-header {
        padding-left: 15px;
        padding-right: 15px;
    }

    /* Bouton menu hamburger dans le header (visible seulement sur mobile) */
    .header-content {
        position: relative; /* Important pour positionner le hamburger icon absolument */
    }
    .hamburger-icon { /* Réutilisation du style du VisitorLayout.vue */
        position: absolute;
        top: 20px; /* Ajuster selon besoin */
        right: 20px; /* Ajuster selon besoin */
        display: block;
        cursor: pointer;
        padding: 10px;
    }
    .hamburger-icon .line { /* Réutilisation du style du VisitorLayout.vue */
        width: 25px;
        height: 3px;
        background-color: #333;
        margin: 5px 0;
        display: block;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
    .hamburger-icon.open .line1 { /* Réutilisation du style du VisitorLayout.vue */
        transform: rotate(-45deg) translate(-6px, 7px);
    }
    .hamburger-icon.open .line2 { /* Réutilisation du style du VisitorLayout.vue */
        opacity: 0;
    }
    .hamburger-icon.open .line3 { /* Réutilisation du style du VisitorLayout.vue */
        transform: rotate(45deg) translate(-6px, -8px);
    }
    .agence-sidebar.sidebar-open + .hamburger-icon { /* Optionnel: Style si besoin quand menu ouvert */
        /* Par exemple changer la couleur du hamburger icon quand menu ouvert */
    }
}

@media (max-width: 576px) { /* Styles pour les petits mobiles - ajustements optionnels */
    .agence-main {
        padding-left: 10px;
        padding-right: 10px;
    }
    .agence-header {
        padding-left: 10px;
        padding-right: 10px;
    }
}

</style>
