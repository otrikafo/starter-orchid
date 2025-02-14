<template>
  <div>
    <h1>Agences Immobilières</h1>

    <div class="agences-grid">
      <div v-for="agence in agences.data":key="agence.id" class="agence-card">
        <div class="card-header">
          <h2 class="agence-name">{{ agence.raison_sociale }}</h2>
        </div>
        <div class="card-body">
          <p class="agence-address"><i class="fas fa-map-marker-alt"></i> {{ agence.siege }}</p>
        </div>
        <div class="card-footer">
          <Link :href="route('agences.show', { agence: agence.id })" class="view-detail-link">
            Voir le détail <i class="fas fa-arrow-right"></i>
          </Link>
        </div>
      </div>
    </div>

    <Pagination :links="agences.links" />
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import VisitorLayout from '@/Layouts/VisitorLayout.vue';
import Pagination from '@/Components/Pagination.vue';

defineOptions({
  layout: VisitorLayout,
});

const props = defineProps({
  agences: Object,
});
</script>

<style scoped>.agences-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Responsive grid */
  gap: 20px;
  margin-top: 20px;
}.agence-card {
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden; /* Ensure content stays within rounded corners */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease-in-out;
  display: flex; /* Use flexbox for card layout */
  flex-direction: column; /* Stack header, body, footer vertically */
}.agence-card:hover {
  transform: scale(1.02);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}.card-header {
  background-color: #f8f9fa;
  padding: 15px;
  border-bottom: 1px solid #eee;
}.agence-name {
  margin: 0;
  font-size: 1.2em;
  color: #333;
}.card-body {
  padding: 15px;
  flex-grow: 1; /* Allow body to take up remaining space */
  display: flex;
  flex-direction: column;
  justify-content: center; /* Center address vertically */
}.agence-address {
  margin: 0;
  color: #555;
  font-size: 0.95em;
  display: flex;
  align-items: center; /* Align icon and text */
}.agence-address i {
  margin-right: 8px;
  color: #777;
}
.card-footer {
  padding: 15px;
  background-color: #f8f9fa;
  border-top: 1px solid #eee;
  text-align: right; /* Align link to the right */
}.view-detail-link {
  display: inline-flex;
  align-items: center;
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.2s ease;
}.view-detail-link:hover {
  color: #0056b3;
  text-decoration: underline;
}.view-detail-link i {
  margin-left: 5px;
}
</style>
