<template>
  <div>
    <h1>Mes Biens Immobiliers</h1>
    <Link :href="route('agence.biens.create')" class="create-bien-button">Créer un nouveau bien</Link>

    <div class="biens-table-container">
      <table>
        <thead>
          <tr>
            <th>Titre</th>
            <th>Ville</th>
            <th>Prix (€)</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="bien in $props.biens.data":key="bien.id">
            <td>{{ bien.titre }}</td>
            <td>{{ bien.ville }}</td>
            <td>{{ bien.prix }}</td>
            <td class="actions-column">
              <Link :href="route('agence.biens.show', { bien: bien.id })" class="action-button view-button">Voir</Link>
              <Link :href="route('agence.biens.edit', { bien: bien.id })" class="action-button edit-button">Modifier</Link>
              <button @click="destroy(bien.id)" class="action-button delete-button">Supprimer</button>
            </td>
          </tr>
          <tr v-if="biens.data.length === 0">
            <td colspan="4" class="no-biens">Aucun bien immobilier enregistré.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <Pagination :links="biens.links" />
  </div>
</template>

<script setup>
import Pagination from '@/Components/Pagination.vue';
import { Link, usePage } from '@inertiajs/vue3';
import AgenceLayout from '@/Layouts/AgenceLayout.vue';

defineOptions({
  layout: AgenceLayout,
});
const props = defineProps({
  biens: Object,
});

const destroy = (id) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer ce bien?')) {
    // Inertia.delete(route('agence.biens.destroy', { bien: id }));
  }
};
</script>

<style scoped>.create-bien-button {
  display: inline-block;
  margin-bottom: 20px;
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.2s ease;
}.create-bien-button:hover {
  background-color: #0056b3;
}.biens-table-container {
  overflow-x: auto; /* Enable horizontal scrolling for smaller screens */
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  background-color: #fff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden; /* Ensure rounded corners are respected */
}

thead {
  background-color: #f8f9fa;
  border-bottom: 2px solid #ddd;
}

th, td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

th {
  font-weight: bold;
  color: #555;
}

tbody tr:last-child td {
  border-bottom: none; /* Remove border from the last row */
}.actions-column {
  text-align: right; /* Align actions to the right */
  white-space: nowrap; /* Prevent actions from wrapping */
}.action-button {
  display: inline-block;
  padding: 8px 12px;
  margin-left: 5px;
  border-radius: 5px;
  text-decoration: none;
  font-size: 0.9em;
  transition: background-color 0.2s ease, color 0.2s ease;
  cursor: pointer;
  border: none; /* Remove default button border */
}.view-button {
  background-color: #28a745; /* Green */
  color: white;
}.edit-button {
  background-color: #ffc107; /* Yellow */
  color: #333;
}.delete-button {
  background-color: #dc3545; /* Red */
  color: white;
}.action-button:hover {
  opacity: 0.9;
}.no-biens {
  text-align: center;
  padding: 15px;
  font-style: italic;
  color: #777;
}
</style>
