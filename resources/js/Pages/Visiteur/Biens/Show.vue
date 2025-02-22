<template>
  <div class="bien-detail-container">
    <h1 class="bien-detail-title">{{ bien.titre }}</h1>

    <div class="bien-meta-info">
      <p class="agence-link">
        Agence: <Link :href="route('agences.show', { agence: bien.agence.id })" class="agence-name">{{ bien.agence.raison_sociale }}</Link>
      </p>
      <p class="bien-address"><i class="fas fa-map-marker-alt"></i> {{ bien.adresse }}, {{ bien.ville }}</p>
      <p class="bien-price"><i class="fas fa-euro-sign"></i> {{ bien.prix }} € <span class="type-transaction">{{ bien.type_transaction === 'vente' ? '(Vente)' : '(Location)' }}</span></p>
    </div>

    <div class="bien-image-section">
      <div class="main-image-container" v-if="bien.image_principale">
        <img :src="`/storage/${bien.image_principale}`" :alt="bien.titre" class="main-image" @click="openModal(bien.image_principale)" />
      </div>

      <div class="thumbnail-gallery" v-if="bien.images_secondaires.length > 0 || bien.image_principale">
        <div class="thumbnail-item" v-if="bien.image_principale">
          <img :src="`/storage/${bien.image_principale}`" :alt="bien.titre" class="thumbnail-image" @click="openModal(bien.image_principale)" />
        </div>
        <div class="thumbnail-item" v-for="(image, index) in bien.images_secondaires" :key="index">
          <img :src="`/storage/${image.chemin}`" :alt="`${bien.titre} - Image secondaire ${index + 1}`" class="thumbnail-image" @click="openModal(image.chemin)" />
        </div>
      </div>

      <div v-if="isModalOpen" class="image-modal" @click.self="closeModal">
        <span class="modal-close-button" @click="closeModal">&times;</span>
        <img :src="`/storage/${modalImageSrc}`" :alt="bien.titre" class="modal-image" />
      </div>
    </div>

    <div class="bien-description-section">
      <h3 class="section-title">Description</h3>
      <p class="bien-description">{{ bien.description }}</p>
    </div>
    <div v-if="$page.props.auth.visiteur" class="contact-agence-section">
        </div>
    <div  v-if="$page.props.auth.visiteur" class="contact-agence-section">
      <ContactAgenceForm :bien-id="bien.id" :agence-id="bien.agence.id" />
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue';
import ContactAgenceForm from '@/Components/ContactAgenceForm.vue';
import { ref, onMounted } from 'vue';
// import ChatBox from '@/Components/ChatBox.vue';
defineOptions({
  layout: VisitorLayout,
});

const props = defineProps({
  bien: Object,
  roomId: String,
});


const isModalOpen = ref(false);
const modalImageSrc = ref('');

const openModal = (imageSrc) => {
  modalImageSrc.value = imageSrc;
  isModalOpen.value = true;
  document.body.style.overflow = 'hidden'; // Empêcher le scroll du body
};

const closeModal = () => {
  isModalOpen.value = false;
  modalImageSrc.value = '';
  document.body.style.overflow = ''; // Réactiver le scroll du body
};


onMounted(() => {
});
</script>

<style scoped>
.bien-detail-container {
  padding: 30px;
  background-color: #f9f9f9;
}

.bien-detail-title {
  font-size: 2.5em;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.bien-meta-info {
  margin-bottom: 25px;
  text-align: center; /* Centrer les infos méta */
}

.agence-link,
.bien-address,
.bien-price {
  margin-bottom: 8px;
  color: #555;
  font-size: 1.1em;
  display: block; /* Afficher chaque info sur une ligne */
}

.agence-name {
  font-weight: bold;
  color: #007bff;
  text-decoration: none;
}

.agence-name:hover {
  text-decoration: underline;
}

.bien-address i,
.bien-price i {
  color: #007bff; /* Couleur des icônes */
  margin-right: 5px;
}

.bien-price {
  font-size: 1.3em;
  font-weight: bold;
  color: #007bff;
}

.type-transaction {
  font-weight: normal;
  color: #777;
  font-size: 0.9em;
  margin-left: 5px;
}


/* Nouvelle Galerie d'Images */
.bien-image-section {
  margin-bottom: 30px;
}

.main-image-container {
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
  margin-bottom: 20px; /* Espace entre image principale et miniatures */
  cursor: pointer; /* Indiquer que l'image est cliquable */
}

.main-image {
  display: block; /* Supprimer l'espace sous l'image */
  width: 100%;
  height: auto; /* Hauteur auto pour conserver aspect ratio */
  object-fit: cover; /* 'cover' pour remplir le conteneur, 'contain' si vous préférez */
  aspect-ratio: 16/9; /* Ratio 16:9 par défaut, peut être ajusté */
}


.thumbnail-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); /* Grille responsive */
  gap: 8px; /* Espacement entre les miniatures */
}

.thumbnail-item {
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  cursor: pointer; /* Indiquer que les miniatures sont cliquables */
  aspect-ratio: 1/1; /* Ratio carré pour les miniatures */
  position: relative; /* Pour le pseudo-élément de survol */
}

.thumbnail-image {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover; /* 'cover' pour remplir le conteneur */
  transition: transform 0.2s ease; /* Animation de zoom au survol */
}

.thumbnail-item:hover .thumbnail-image {
  transform: scale(1.05); /* Zoom léger au survol */
}


/* Style Modal (Lightbox) */
.image-modal {
  position: fixed; /* Fixed pour couvrir toute la fenêtre */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8); /* Fond semi-transparent noir */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000; /* Assurer que la modale est au-dessus de tout */
}

.modal-close-button {
  position: absolute;
  top: 20px;
  right: 30px;
  color: #fff;
  font-size: 3em;
  cursor: pointer;
  opacity: 0.7;
  transition: opacity 0.2s ease;
}

.modal-close-button:hover {
  opacity: 1;
}

.modal-image {
  max-width: 90%; /* Largeur max de l'image dans la modale */
  max-height: 90%; /* Hauteur max de l'image dans la modale */
  object-fit: contain; /* 'contain' pour afficher l'image entière dans la modale */
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}


/* Description Section - Styles inchangés */
.bien-description-section {
  margin-bottom: 30px;
  padding: 20px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.section-title {
  font-size: 1.6em;
  color: #333;
  margin-top: 0;
  margin-bottom: 15px;
  border-bottom: 2px solid #eee;
  padding-bottom: 8px;
}

.bien-description {
  color: #666;
  line-height: 1.7;
}

/* Contact Agence Section - Styles inchangés */
.contact-agence-section {
  /* Vous pouvez ajouter des styles spécifiques si nécessaire */
}
</style>
