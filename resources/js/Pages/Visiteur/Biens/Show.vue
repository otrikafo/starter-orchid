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
      <div class="bien-image-slider">
        <div class="slider-container">
          <div class="slider-wrapper" :style="{ transform: `translateX(-${slideIndex * 100}%)` }">
            <div class="slide" v-if="bien.image_principale">
              <img :src="`/storage/${bien.image_principale}`" :alt="bien.titre" class="slide-image main-image" />
            </div>
            <div class="slide" v-for="(image, index) in bien.images_secondaires" :key="index">
              <img :src="`/storage/${image.chemin}`" :alt="`${bien.titre} - Image secondaire ${index + 1}`" class="slide-image secondary-image" />
            </div>
          </div>
          <div class="slider-controls" v-if="bien.images_secondaires.length + (bien.image_principale ? 1 : 0) > 1">
            <button class="slider-control prev" @click="prevSlide">❮</button>
            <button class="slider-control next" @click="nextSlide">❯</button>
          </div>
        </div>
      </div>
    </div>

    <div class="bien-description-section">
      <h3 class="section-title">Description</h3>
      <p class="bien-description">{{ bien.description }}</p>
    </div>
    <div v-if="$page.props.auth.visiteur" class="contact-agence-section">
        <!-- <ChatBox :bien-id="bien.id" :agence-id="bien.agence.id" :room-id="roomId" /> -->
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

const slideIndex = ref(0); // Index du slide pour le slider de ce bien

const nextSlide = () => {
  const totalSlides = (props.bien.images_secondaires.length) + (props.bien.image_principale ? 1 : 0);
  slideIndex.value = (slideIndex.value + 1) % totalSlides;
};

const prevSlide = () => {
  const totalSlides = (props.bien.images_secondaires.length) + (props.bien.image_principale ? 1 : 0);
  slideIndex.value = (slideIndex.value - 1 + totalSlides) % totalSlides;
};

onMounted(() => {
  slideIndex.value = 0; // Initialiser l'index du slider à 0 au montage
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


/* Image Slider Styles (Réutilisés et légèrement adaptés de la liste) */
.bien-image-section {
  margin-bottom: 30px;
}

.bien-image-slider {
  position: relative;
  height: 400px; /* Hauteur plus importante pour la page de détail */
  overflow: hidden;
  border-radius: 10px; /* Plus arrondi pour la page de détail */
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15); /* Ombre plus prononcée */
}

.slider-container {
  width: 100%;
  height: 100%;
  position: relative;
}

.slider-wrapper {
  display: flex;
  height: 100%;
  transition: transform 0.5s ease-in-out;
}

.slide {
  flex: 1 0 100%;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.slide-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain; /* 'contain' pour afficher l'image entière sans la couper */
  display: block;
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
  pointer-events: none;
}

.slider-control {
  pointer-events: auto;
  background: rgba(255, 255, 255, 0.8); /* Fond plus opaque pour la page détail */
  color: #333;
  border: none;
  padding: 12px 18px; /* Plus grands boutons */
  border-radius: 8px; /* Plus arrondis */
  margin: 15px;
  cursor: pointer;
  font-size: 1.2em; /* Plus grands boutons */
  transition: background-color 0.3s ease;
}

.slider-control:hover {
  background-color: rgba(255, 255, 255, 0.95); /* Hover plus clair */
}

.slider-control:disabled {
  opacity: 0.5;
  cursor: default;
  pointer-events: none;
}


/* Description Section */
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

/* Contact Agence Section */
.contact-agence-section {
  /* Vous pouvez ajouter des styles spécifiques si nécessaire */
}
</style>
