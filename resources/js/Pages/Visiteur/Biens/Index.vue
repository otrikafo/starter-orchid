<template>
  <div class="biens-disponibles-container">
    <h1 class="biens-disponibles-title">Biens Immobiliers Disponibles</h1>

    <div class="biens-grid">
      <div v-for="bien in $props.biens.data" :key="bien.id" class="bien-card">

        <div class="bien-image-slider">
          <div class="slider-container">
            <div class="slider-wrapper" :style="{ transform: `translateX(-${slideIndex * 100}%)` }">
              <div class="slide" v-if="bien.image_principale">
                <img :src="`/storage/${bien.image_principale}`" :alt="bien.titre" class="slide-image main-image" />
              </div>
              <!-- <div class="slide" v-for="(image, index) in bien.images_secondaires" :key="index">
                <img :src="`/storage/${image.path}`" :alt="`${bien.titre} - Image secondaire ${index + 1}`" class="slide-image secondary-image" />
              </div> -->
            </div>
            <div class="slider-controls" v-if="bien.images_secondaires.length + (bien.image_principale ? 1 : 0) > 1">
              <button class="slider-control prev" @click="prevSlide(bien.id)">❮</button>
              <button class="slider-control next" @click="nextSlide(bien.id)">❯</button>
            </div>
          </div>
        </div>


        <div class="bien-details">
          <h2 class="bien-titre">{{ bien.titre }}</h2>
          <p class="bien-ville"><i class="fas fa-map-marker-alt"></i> {{ bien.ville }}</p>
          <p class="bien-prix">{{ bien.prix }} € <span class="type-transaction">{{ bien.type_transaction === 'vente' ? '(Vente)' : '(Location)' }}</span></p>
          <p class="bien-type"><i class="fas fa-home"></i> Type: {{ bien.type_bien }}</p>
          <Link :href="route('biens.show', { bien: bien.id })" class="bien-link">Voir le détail <i class="fas fa-arrow-right"></i></Link>
        </div>
      </div>
    </div>

    <Pagination :links="biens.links" />
  </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import VisitorLayout from '@/Layouts/VisitorLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
  biens: Object,
});

defineOptions({
  layout: VisitorLayout,
});

const slideIndexes = ref({}); // Stocker l'index du slider pour chaque bien

const nextSlide = (bienId) => {
  if (!slideIndexes.value[bienId]) {
    slideIndexes.value[bienId] = 0; // Initialiser si non défini
  }
  const totalSlides = (props.biens.data.find(bien => bien.id === bienId).images_secondaires.length) + (props.biens.data.find(bien => bien.id === bienId).image_principale ? 1 : 0);
  slideIndexes.value[bienId] = (slideIndexes.value[bienId] + 1) % totalSlides;
};

const prevSlide = (bienId) => {
  if (!slideIndexes.value[bienId]) {
    slideIndexes.value[bienId] = 0; // Initialiser si non défini
  }
  const totalSlides = (props.biens.data.find(bien => bien.id === bienId).images_secondaires.length) + (props.biens.data.find(bien => bien.id === bienId).image_principale ? 1 : 0);
  slideIndexes.value[bienId] = (slideIndexes.value[bienId] - 1 + totalSlides) % totalSlides;
};

onMounted(() => {
  props.biens.data.forEach(bien => {
    slideIndexes.value[bien.id] = 0; // Initialiser l'index du slider pour chaque bien à 0 au montage
  });
});


</script>

<style scoped>
.biens-disponibles-container {
  padding: 20px;
  background-color: #f9f9f9;
}

.biens-disponibles-title {
  text-align: center;
  color: #333;
  margin-bottom: 30px;
  font-size: 2em;
}

.biens-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Grille responsive */
  gap: 30px;
}

.bien-card {
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden; /* Important pour border-radius sur les images */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
  transition: transform 0.2s ease-in-out;
  display: flex; /* Utilisation de flexbox pour diviser en image et détails */
  flex-direction: column; /* Image au-dessus des détails */
}

.bien-card:hover {
  transform: scale(1.03);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}


/* Slider Styles */
.bien-image-slider {
  position: relative; /* Pour positionner les contrôles */
  height: 200px; /* Hauteur fixe pour le slider, ajustez selon besoin */
  overflow: hidden; /* Masque les images qui dépassent */
}

.slider-container {
  width: 100%;
  height: 100%;
  position: relative;
}

.slider-wrapper {
  display: flex;
  height: 100%;
  width: 100%; /* Important pour que le wrapper prenne toute la largeur du container */
  transition: transform 0.5s ease-in-out; /* Animation de transition */
}

.slide {
  flex: 1 0 100%; /* Chaque slide prend 100% de la largeur du wrapper */
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center; /* Centrer horizontalement */
  align-items: center; /* Centrer verticalement */
}

.slide-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover; /* Remplir l'espace en conservant l'aspect ratio */
  display: block; /* Supprimer l'espace sous l'image */
}

.main-image {
    /* Styles spécifiques pour l'image principale si nécessaire */
}

.secondary-image {
    /* Styles spécifiques pour les images secondaires si nécessaire */
}

.slider-controls {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transform: translateY(-50%);
  pointer-events: none; /* Permettre aux clics de passer à travers si nécessaire */
}

.slider-control {
  pointer-events: auto; /* Rendre les boutons cliquables */
  background: rgba(255, 255, 255, 0.7); /* Fond semi-transparent pour les boutons */
  color: #333;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  margin: 10px;
  cursor: pointer;
  font-size: 1em;
  transition: background-color 0.3s ease;
}

.slider-control:hover {
  background-color: rgba(255, 255, 255, 0.9);
}

.slider-control:disabled {
  opacity: 0.5;
  cursor: default;
  pointer-events: none;
}


/* Details Styles */
.bien-details {
  padding: 20px;
  display: flex;
  flex-direction: column;
}

.bien-titre {
  margin-top: 0;
  margin-bottom: 10px;
  font-size: 1.5em;
  color: #333;
}

.bien-ville,
.bien-prix,
.bien-type {
  margin-top: 0;
  margin-bottom: 8px;
  color: #555;
  font-size: 1em;
  display: flex; /* Aligner icône et texte */
  align-items: center;
  gap: 5px; /* Espacement entre icône et texte */
}

.bien-ville i,
.bien-prix i,
.bien-type i {
  color: #007bff; /* Couleur des icônes */
}

.bien-prix {
  font-weight: bold;
  color: #007bff;
}

.type-transaction {
  font-weight: normal;
  color: #777;
  font-size: 0.9em;
  margin-left: 5px;
}

.bien-link {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.2s ease;
  margin-top: 15px;
  align-self: flex-start; /* Aligner à gauche dans le container flex */
  display: flex; /* Pour aligner icône et texte */
  align-items: center;
  gap: 5px;
}

.bien-link:hover {
  background-color: #0056b3;
}
</style>
