<template>
  <div class="visitor-layout">
    <header class="visitor-header">
      <nav class="visitor-nav">
        <div class="nav-left">
          <Link :href="route('home')" class="nav-brand">Site Immobilier</Link>
        </div>

        <div class="hamburger-icon" :class="{ open: isMobileMenuOpen }" @click="toggleMobileMenu">
            <span class="line line1"></span>
            <span class="line line2"></span>
            <span class="line line3"></span>
        </div>
      </nav>
    </header>

    <aside class="visitor-sidebar" :class="{ 'sidebar-open': isMobileMenuOpen }">
        <nav class="visitor-sidebar-nav">

        <Link :href="route('biens.index')" class="sidebar-item">Biens</Link>
        <div class="sidebar-item has-submenu"  :class="{ 'active': showAgencesSubmenu }" @click="toggleAgencesSubmenu">
            <span>Agences <i class="fas fa-caret-down submenu-arrow"></i></span>
            <div class="submenu" v-if="showAgencesSubmenu">
              <Link :href="route('agences.index')" class="submenu-item">Liste des Agences</Link>
              <Link v-if="!$page.props.auth.visiteur" :href="route('agence.inscription')" class="submenu-item">Devenir agence</Link>
            </div>
          </div>
          <Link :href="route('a-propos')" class="sidebar-item">À propos</Link>
          <Link :href="route('mentions-legales')" class="sidebar-item">Mentions Légales</Link>
          <Link :href="route('politique-confidentialite')" class="sidebar-item">Politique de Confidentialité</Link>
            <ChatLinkWithCounter :chatRoute="route('chat.index')" :messageCount="unreadMessageCount" class="sidebar-item">
                Messages Privés
            </ChatLinkWithCounter>
          <div class="mon-compte-menu sidebar-item"  :class="{ active: isMonCompteMenuOpen }" @click.prevent="toggleMonCompteMenu">
            <span class="mon-compte-label">Mon compte</span>
            <div class="mon-compte-dropdown">
              <Link v-if="!$page.props.auth" :href="route('visiteur.connexion')" class="dropdown-item">Se connecter</Link>
              <Link v-if="$page.props.auth.agence" :href="route('agence.connexion')" class="dropdown-item">Espace agence</Link>
              <Link v-if="$page.props.auth.visiteur" :href="route('visiteur.deconnexion')" method="post" as="button" class="dropdown-item">Déconnexion</Link>
              <Link v-if="$page.props.auth.agence" :href="route('agence.deconnexion')" method="post" as="button" class="dropdown-item">Déconnexion</Link>
              <span v-if="$page.props.auth.visiteur" class="dropdown-item user-email">{{ $page.props.auth.visiteur.email }}</span>
            </div>
          </div>
        </nav>
    </aside>

    <VisitorBreadcrumbs :breadcrumbs="pageBreadcrumbs" />
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

import { ref, computed } from 'vue';
import VisitorBreadcrumbs from '@/Components/VisitorBreadcrumbs.vue'; // Importez le composant
import ChatLinkWithCounter from '@/Components/ChatLinkWithCounter.vue'; // Importez le composant

const page = usePage();

const pageBreadcrumbs = computed(() => {
    return page.props.breadcrumbs || []; // Récupérez les breadcrumbs depuis les props de la page Inertia
});

const isMonCompteMenuOpen = ref(false); // État pour contrôler l'affichage du dropdown "Mon Compte" sur mobile
const isMobileMenuOpen = ref(false); // Nouvel état pour le menu mobile (fermé par défaut)
const showAgencesSubmenu = ref(false);


const toggleMonCompteMenu = () => {
    isMonCompteMenuOpen.value = !isMonCompteMenuOpen.value;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value; // Basculer l'état du menu mobile
    showAgencesSubmenu.value = false; // Fermer le submenu "Agences" quand on ouvre/ferme le menu mobile
    isMonCompteMenuOpen.value = false; // Fermer le menu "Mon Compte" quand on ouvre/ferme le menu mobile
};
const toggleAgencesSubmenu = () => {
    showAgencesSubmenu.value = !showAgencesSubmenu.value;
};


// import ChatBox from '@/Components/ChatBox.vue';
const unreadMessageCount = ref(1);
</script>

<style scoped>
.visitor-layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    padding: 0.5em;
}

.visitor-header {
    background-color: #f8f9fa;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.visitor-sidebar-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    max-width: 1200px;
    margin: 0 auto;
    position: relative; /* Pour positionner hamburger icon */
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
    /* padding: 5px 10px; */
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
    display: block;
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


/* Media Queries pour Responsive Design */

/* ... CSS précédent ... */

@media (max-width: 768px) { /* Styles pour les écrans de tablette et mobiles */
    .visitor-nav {
        /* flex-direction: column; - PAS BESOIN FLEX DIRECTION COLUMN POUR LE HEADER */
        align-items: center; /* Centrer verticalement les éléments du header */
        padding: 10px 20px;
        position: relative; /* Pour positionner le hamburger icon absolument */
        justify-content: space-between; /* Espacer logo et hamburger */
    }

    .nav-brand {
        margin-bottom: 0; /* Supprimer la marge bottom du logo sur mobile */
    }

    .nav-right {
        display: none; /* Cacher la navigation par défaut sur mobile initialement */
    }
    .visitor-sidebar { /* Style pour la sidebar mobile */
        position: fixed; /* Sidebar en position fixed */
        top: 0;
        left: 0;
        height: 100%; /* Pleine hauteur de la fenêtre */
        width: 250px; /* Largeur de la sidebar */
        z-index: 100; /* Pour être au-dessus du contenu */
        background-color: #f0f0f0; /* Couleur de fond de la sidebar */
        transform: translateX(-250px); /* Cacher initialement hors écran */
        transition: transform 0.3s ease; /* Animation slide-in/slide-out */
        padding-top: 60px; /* Espace pour le header fixe */
        overflow-y: auto; /* Scroll si contenu dépasse */
    }
    .visitor-sidebar.sidebar-open { /* Classe pour afficher la sidebar */
        transform: translateX(0); /* Afficher en ramenant dans l'écran */
    }
    .visitor-sidebar-nav { /* Styles pour la navigation DANS la sidebar */
        padding: 0 20px;
    }
    .sidebar-item { /* Styles pour chaque item de navigation dans la sidebar */
        display: block;
        padding: 10px 15px;
        color: #555;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 8px;
        transition: background-color 0.2s ease;
        display: flex; /* Pour aligner icône et texte (si vous ajoutez des icônes) */
        align-items: center;
        border-bottom: 1px solid #eee; /* Séparateur entre les items */
        text-align: left;
        position: relative;
    }
    .sidebar-item:last-child {
        border-bottom: none; /* Pas de séparateur sur le dernier item */
    }


    .sidebar-item:hover,
    .sidebar-item.active {
        background-color: #e0e0e0; /* Couleur au survol/actif */
    }
    .sidebar-icon {
        margin-right: 10px; /* Espace pour les icônes (si ajoutées) */
        font-size: 1.2em;
    }
    .submenu {
        position: absolute; /* Pour submenu dans sidebar */
        top: 100%;
        right: 0;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px 0;
        width: 180px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .sidebar-item.has-submenu.open .submenu { /* Afficher submenu quand parent a la classe 'open' */
        display: block;
    }
    .submenu-item {
        padding: 10px 15px;
        border-bottom: none; /* Supprimer bordure des items de submenu */
    }


    .visitor-main {
        margin-top: 0; /* Supprimer la marge top du main sur mobile */
        padding: 15px;
        width: 100%;
    }

    /* Style pour le bouton hamburger - REUTILISATION DU STYLE VISITOR LAYOUT */
    .hamburger-icon {
        position: relative; /* Positionnement relatif dans .visitor-nav */
        top: auto; /* Réinitialiser top et right */
        right: auto;
        display: block; /* Afficher le hamburger sur mobile */
        cursor: pointer;
        padding: 10px;
    }
    .hamburger-icon .line { /* REUTILISATION DU STYLE VISITOR LAYOUT */
        width: 25px;
        height: 3px;
        background-color: #333;
        margin: 5px 0;
        display: block; /* Assurer que les lignes sont en blocs */
        transition: transform 0.3s ease, opacity 0.3s ease; /* Transitions pour l'animation */
    }
    .hamburger-icon.open .line1 {
        transform: rotate(-45deg) translate(-6px, 7px); /* Animation croix ligne 1 */
    }
    .hamburger-icon.open .line2 {
        opacity: 0; /* Cacher la ligne du milieu pour la croix */
    }
    .hamburger-icon.open .line3 {
        transform: rotate(45deg) translate(-6px, -8px); /* Animation croix ligne 3 */
    }
    .visitor-nav.mobile-menu-open + .hamburger-icon { /* Optionnel: Style si besoin quand menu ouvert */
        /* Par exemple changer la couleur du hamburger icon quand menu ouvert */
    }


}

@media (max-width: 576px) { /* Styles pour les petits mobiles */
    .visitor-nav {
        padding-left: 15px;
        padding-right: 15px;
    }
    .visitor-main {
        padding: 10px;
        width: 100%;
    }
}
</style>
