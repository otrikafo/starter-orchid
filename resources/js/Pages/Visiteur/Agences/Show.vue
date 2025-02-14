<template>
  <div class="agence-show-container">
    <div class="agence-header">
      <h1 class="agence-name">{{ $page.props.agence.raison_sociale }}</h1>
    </div>

    <section class="agence-details-section">
      <div class="detail-card">
        <h2 class="section-title">Informations de l'agence</h2>
        <div class="detail-item">
          <i class="fas fa-map-marker-alt detail-icon"></i>
          <span>{{ $page.props.agence.siege }}</span>
        </div>
        <div class="detail-item">
          <i class="fas fa-envelope detail-icon"></i>
          <a :href="`mailto:${$page.props.agence.email}`" class="detail-link">{{ $page.props.agence.email }}</a>
        </div>
        </div>
    </section>

    <section class="biens-section">
      <h2 class="section-title">Biens proposés par cette agence</h2>
      <div class="biens-grid" v-if="$page.props.agence.biens.length > 0">
        <div v-for="bien in $page.props.agence.biens" :key="bien.id" class="bien-card">
          <h3 class="bien-title">{{ bien.titre }}</h3>
          <p class="bien-location"><i class="fas fa-map-marker-alt"></i> {{ bien.ville }}</p>
          <p class="bien-price">{{ bien.prix }} €</p>
          <Link :href="route('biens.show', { bien: bien.id })" class="view-detail-link">
            Voir le détail <i class="fas fa-arrow-right"></i>
          </Link>
        </div>
      </div>
      <div v-else class="empty-section">
        <p>Cette agence n'a pas encore de biens à proposer.</p>
      </div>
    </section>

    <section class="avis-section">
      <h2 class="section-title">Avis sur cette agence</h2>
      <div class="avis-list" v-if="$page.props.agence.avis_agences.length > 0">
        <div v-for="avis in $page.props.agence.avis_agences" :key="avis.id" class="avis-card">
          <div class="avis-header">
            <div class="avis-rating">Note: <span class="rating-value">{{ avis.note }}</span>/5 <i class="fas fa-star star-icon"></i></div>
            <div class="avis-author">Par: {{ avis.visiteur.email }}</div>
          </div>
          <div class="avis-body">
            <p class="avis-comment">"{{ avis.commentaire }}"</p>
          </div>
          <div class="avis-footer">
            <span class="avis-date">Le: {{ new Date(avis.created_at).toLocaleDateString() }}</span>
          </div>
        </div>
      </div>
      <div v-else class="empty-section">
        <p>Aucun avis pour le moment.</p>
      </div>
        <!-- Empecher l'affichage du formualaire si l'utilisateur a déjà noté -->
        <div class="avis-action" v-if="$page.props.auth.visiteur && !$page.props.aDejaLaisseAvis">
            <AvisAgenceForm :agenceId="$page.props.agence.id" />
        </div>
        <!-- Si pas encore laissé un avis -->
        <div class="avis-action" v-if="$page.props.auth.visiteur && $page.props.aDejaLaisseAvis">
            <p>Vous avez déjà laissé un avis sur cette agence.</p>
        </div>
        <div class="avis-action" v-else>
            <Link :href="route('visiteur.connexion')" class="avis-button login-button">Se connecter pour laisser un avis <i class="fas fa-sign-in-alt"></i></Link>
        </div>
    </section>
    <section>
        <!-- <ContactAgenceForm :agenceId="$page.props.agence.id" /> -->
    </section>
  </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue';
import AvisAgenceForm from '@/Components/AvisAgenceForm.vue'; // Importez le composant AvisAgenceForm
// Component formulaire de contact
// import ContactAgenceForm from '@/Components/ContactAgenceForm.vue'; // Importez le composant ContactAgenceForm

defineOptions({
  layout: VisitorLayout,
});
const props = defineProps({
  agence: Object,
  aDejaLaisseAvis: Boolean,
});

</script>

<style scoped>
.agence-show-container {
  padding: 20px;
  font-family: 'Arial', sans-serif;
  color: #333;
  max-width: 1000px;
  margin: 0 auto;
}

.agence-header {
  text-align: center;
  margin-bottom: 30px;
}

.agence-name {
  font-size: 2em;
  color: #007bff;
  margin-bottom: 10px;
}

.section-title {
  font-size: 1.5em;
  margin-bottom: 15px;
  border-bottom: 2px solid #eee;
  padding-bottom: 8px;
}

/* Agence Details Section */
.agence-details-section {
  margin-bottom: 30px;
}

.detail-card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
  padding: 20px;
}

.detail-item {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  font-size: 1em;
}

.detail-icon {
  margin-right: 10px;
  color: #777;
}

.detail-link {
  color: #007bff;
  text-decoration: none;
}

.detail-link:hover {
  text-decoration: underline;
}


/* Biens Section */
.biens-section {
  margin-bottom: 30px;
}

.biens-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 15px;
}

.bien-card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
  padding: 15px;
  display: flex;
  flex-direction: column;
}

.bien-title {
  font-size: 1.1em;
  margin-top: 0;
  margin-bottom: 8px;
}

.bien-location, .bien-price {
  margin: 5px 0;
  color: #555;
  font-size: 0.9em;
  display: flex;
  align-items: center;
}

.bien-location i {
  margin-right: 5px;
  color: #777;
}

.bien-price {
  font-weight: bold;
}

.view-detail-link {
  display: inline-flex;
  align-items: center;
  color: #007bff;
  text-decoration: none;
  font-size: 0.9em;
  font-weight: bold;
  margin-top: 10px;
}

.view-detail-link i {
  margin-left: 5px;
}


/* Avis Section */
.avis-section {
  margin-bottom: 30px;
}

.avis-list {
  margin-top: 15px;
}

.avis-card {
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
  padding: 15px;
  margin-bottom: 10px;
  border: 1px solid #eee;
}

.avis-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  border-bottom: 1px solid #eee;
  padding-bottom: 5px;
}

.avis-rating {
  font-weight: bold;
  color: #495057;
  display: flex;
  align-items: center;
}

.rating-value {
  color: #ffc107; /* Couleur or pour la note */
  margin-right: 5px;
}

.star-icon {
  color: #ffc107; /* Couleur or pour l'étoile */
  font-size: 0.8em;
}


.avis-author {
  font-size: 0.9em;
  color: #777;
}

.avis-body {
  margin-bottom: 10px;
}

.avis-comment {
  font-style: italic;
  color: #555;
  quotes: "“" "”"; /* Pour les guillemets typographiques */
}

.avis-comment:before {
  content: open-quote;
}

.avis-comment:after {
  content: close-quote;
}


.avis-footer {
  text-align: right;
  font-size: 0.85em;
  color: #777;
}

.avis-action {
  margin-top: 20px;
  text-align: center;
}

.avis-button {
  display: inline-flex;
  align-items: center;
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.2s ease;
}

.avis-button:hover {
  background-color: #0056b3;
}

.avis-button i {
  margin-left: 8px;
}

.avis-button.login-button {
  background-color: #6c757d; /* Couleur grise pour le bouton de connexion */
}

.avis-button.login-button:hover {
  background-color: #5a6268;
}


.empty-section {
  font-style: italic;
  color: #777;
  margin-top: 10px;
}
</style>
