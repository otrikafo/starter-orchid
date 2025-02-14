<template>
  <div class="bien-detail-container">
    <header class="bien-header">
      <h1 class="bien-title">{{ $props.bien.titre }}</h1>
      <p class="agence-name">Agence: {{ $props.bien.agence.raison_sociale }}</p>
    </header>

    <section class="bien-details">
      <div class="detail-item address">
        <i class="fas fa-map-marker-alt detail-icon"></i>
        <span>{{ $props.bien.adresse }}, {{ $props.bien.ville }}</span>
      </div>
      <div class="detail-item price">
        <i class="fas fa-euro-sign detail-icon"></i>
        <span>{{ $props.bien.prix }} €</span>
      </div>
      <div class="detail-item description">
        <h2 class="detail-subtitle">Description</h2>
        <p class="detail-text">{{ $props.bien.description }}</p>
      </div>
    </section>

    <section class="images-section">
      <h2 class="section-title">Images</h2>
      <div class="images-carousel">
        <div class="main-image">
          <img v-bind:src="`/storage/${ $props.bien.image_principale}`" alt="Image Principale" class="main-image-src">
        </div>
        <div class="secondary-images">
          <div v-for="image in $props.bien.images_secondaires":key="image.id" class="secondary-image-item">
            <img v-bind:src="`/storage/${image.chemin}`" alt="Image Secondaire" class="secondary-image-src">
          </div>
        </div>
      </div>
    </section>

    <section class="actions-section">
      <Link :href="route('agence.biens.edit', { bien: $props.bien.id })" class="action-button edit-button">Modifier</Link>
      <button @click="destroy($props.bien.id)" class="action-button delete-button">Supprimer</button>
      <Link :href="route('agence.biens.index')" class="action-button back-button">Retour à la liste</Link>
    </section>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import AgenceLayout from '@/Layouts/AgenceLayout.vue';

defineOptions({
  layout: AgenceLayout,
});
const props = defineProps({
  bien: Object,
});

const destroy = (id) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce bien?')) {
    // Inertia.delete(route('agence.biens.destroy', { bien: id }));
  }
};
</script>

<style scoped>.bien-detail-container {
  font-family: 'Arial', sans-serif;
  color: #333;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  max-width: 900px;
  margin: 20px auto;
}.bien-header {
  text-align: center;
  margin-bottom: 30px;
}.bien-title {
  font-size: 2.5em;
  color: #007bff;
  margin-bottom: 10px;
}.agence-name {
  font-size: 1.1em;
  color: #777;
  margin-bottom: 20px;
}.bien-details,.images-section,.actions-section {
  margin-bottom: 30px;
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}.detail-item {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  font-size: 1em;
}.detail-icon {
  margin-right: 10px;
  color: #777;
}.detail-subtitle {
  font-size: 1.3em;
  margin-bottom: 10px;
  color: #333;
}.detail-text {
  color: #555;
  line-height: 1.6;
}

/* Images Section */.images-section.section-title {
    font-size: 1.5em;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}.images-carousel {
  display: flex;
  flex-direction: column;
  align-items: center;
}.main-image {
  margin-bottom: 20px;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  max-width: 100%; /* Ensure main image is responsive */
}.main-image-src {
  display: block; /* Remove extra space below image */
  width: 100%; /* Make image fill container */
  height: auto; /* Maintain aspect ratio */
  max-height: 400px; /* Limit maximum height */
  object-fit: cover; /* Cover container, cropping if necessary */
}
.secondary-images {
  display: flex;
  gap: 10px;
  overflow-x: auto; /* Enable horizontal scrolling for secondary images */
  padding-bottom: 10px; /* Add some space for scrollbar */
}.secondary-image-item {
  width: 120px;
  height: 90px;
  border-radius: 5px;
  overflow: hidden;
  box-shadow: 0 1px 2px rgba(0,0,0,0.1);
  flex-shrink: 0; /* Prevent images from shrinking */
}.secondary-image-src {
  display: block;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease; /* Smooth hover effect */
}.secondary-image-item:hover.secondary-image-src {
  transform: scale(1.1); /* Zoom on hover */
}


/* Actions Section */.actions-section {
  text-align: right;
}.actions-section.action-button {
  padding: 10px 20px;
  margin-left: 10px;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.2s ease, color 0.2s ease;
  cursor: pointer;
  border: none; /* Remove default button border */
  display: inline-block; /* Ensure inline for spacing */
}
.actions-section.edit-button {
  background-color: #ffc107; /* Yellow */
  color: #333;
}.actions-section.delete-button {
  background-color: #dc3545; /* Red */
  color: white;
}.actions-section.back-button {
  background-color: #6c757d; /* Grey */
  color: white;
}
.actions-section.action-button:hover {
  opacity: 0.9;
}
</style>
