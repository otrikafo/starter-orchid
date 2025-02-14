<template>
  <div class="create-bien-container">
    <h1 class="create-bien-title">Créer un Bien Immobilier</h1>
    <form @submit.prevent="submit" class="create-bien-form">
      <div class="form-group">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" id="titre" v-model="form.titre" class="form-input">
        <div v-if="form.errors.titre" class="error">{{ form.errors.titre }}</div>
      </div>

      <div class="form-group">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" v-model="form.description" class="form-textarea"></textarea>
        <div v-if="form.errors.description" class="error">{{ form.errors.description }}</div>
      </div>

      <div class="form-group">
        <label for="prix" class="form-label">Prix</label>
        <input type="number" id="prix" v-model="form.prix" class="form-input">
        <div v-if="form.errors.prix" class="error">{{ form.errors.prix }}</div>
      </div>

      <div class="form-group">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" id="adresse" v-model="form.adresse" class="form-input">
        <div v-if="form.errors.adresse" class="error">{{ form.errors.adresse }}</div>
      </div>

      <div class="form-group">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" id="ville" v-model="form.ville" class="form-input">
        <div v-if="form.errors.ville" class="error">{{ form.errors.ville }}</div>
      </div>

      <div class="form-group">
        <label for="superficie" class="form-label">Superficie (m²)</label>
        <input type="number" id="superficie" v-model="form.superficie" class="form-input">
        <div v-if="form.errors.superficie" class="error">{{ form.errors.superficie }}</div>
      </div>

      <div class="form-group">
        <label for="nombre_pieces" class="form-label">Nombre de pièces</label>
        <input type="number" id="nombre_pieces" v-model="form.nombre_pieces" class="form-input">
        <div v-if="form.errors.nombre_pieces" class="error">{{ form.errors.nombre_pieces }}</div>
      </div>

      <div class="form-group">
        <label for="nombre_chambres" class="form-label">Nombre de chambres</label>
        <input type="number" id="nombre_chambres" v-model="form.nombre_chambres" class="form-input">
        <div v-if="form.errors.nombre_chambres" class="error">{{ form.errors.nombre_chambres }}</div>
      </div>

      <div class="form-group">
        <label for="nombre_salles_de_bain" class="form-label">Nombre de salles de bain</label>
        <input type="number" id="nombre_salles_de_bain" v-model="form.nombre_salles_de_bain" class="form-input">
        <div v-if="form.errors.nombre_salles_de_bain" class="error">{{ form.errors.nombre_salles_de_bain }}</div>
      </div>

      <div class="form-group">
        <label for="type_bien" class="form-label">Type de bien</label>
        <select id="type_bien" v-model="form.type_bien" class="form-select">
          <option value="maison">Maison</option>
          <option value="appartement">Appartement</option>
          <option value="terrain">Terrain</option>
          <option value="commerce">Commerce</option>
        </select>
        <div v-if="form.errors.type_bien" class="error">{{ form.errors.type_bien }}</div>
      </div>

      <div class="form-group">
        <label for="type_transaction" class="form-label">Type de transaction</label>
        <select id="type_transaction" v-model="form.type_transaction" class="form-select">
          <option value="vente">Vente</option>
          <option value="location">Location</option>
        </select>
        <div v-if="form.errors.type_transaction" class="error">{{ form.errors.type_transaction }}</div>
      </div>

      <div class="form-group">
        <label for="image_principale" class="form-label">Image principale</label>
        <input type="file" id="image_principale" name="image_principale" @input="form.image_principale = $event.target.files[0]" class="form-file-input">
        <div v-if="form.errors.image_principale" class="error">{{ form.errors.image_principale }}</div>
      </div>

      <button type="submit" class="form-button" :disabled="form.processing">Créer</button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AgenceLayout from '@/Layouts/AgenceLayout.vue';

defineOptions({
  layout: AgenceLayout,
});
const form = useForm({
  titre: '',
  description: '',
  prix: null,
  adresse: '',
  ville: '',
  superficie: null,
  nombre_pieces: null,
  nombre_chambres: null,
  nombre_salles_de_bain: null,
  type_bien: '',
  type_transaction: '',
  image_principale: null,
});

const submit = () => {
  form.post(route('agence.biens.store'));
};
</script>

<style scoped>
.create-bien-container {
  background-color: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  max-width: 800px;
  margin: 20px auto;
}

.create-bien-title {
  font-size: 2em;
  color: #333;
  margin-top: 0;
  margin-bottom: 30px;
  text-align: center;
}

.create-bien-form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
  color: #555;
}

.form-input,
.form-textarea,
.form-select,
.form-file-input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-family: inherit;
  font-size: 1em;
  box-sizing: border-box;
}

.form-textarea {
  resize: vertical;
  min-height: 150px;
}

.form-select {
  appearance: none; /* Remove default dropdown arrow */
  -webkit-appearance: none; /* For Safari */
  -moz-appearance: none; /* For Firefox */
  background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
  background-repeat: no-repeat;
  background-position-x: 100%;
  background-position-y: 5px;
  padding-right: 30px; /* Space for arrow */
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-file-input {
  padding-top: 10px;
  padding-bottom: 10px;
  border: 1px dashed #ccc; /* Dashed border for file input */
  text-align: center; /* Center file input text */
  background-color: #f8f9fa; /* Light background for file input */
  cursor: pointer; /* Pointer cursor for file input */
  color: #555; /* Darker text color for file input */
}

.form-file-input::-webkit-file-upload-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 15px;
}

.form-file-input::file-selector-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 15px;
}


.form-button {
  padding: 12px 25px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1.1em;
  font-weight: bold;
  transition: background-color 0.2s ease;
  margin-top: 20px;
}

.form-button:hover {
  background-color: #0056b3;
}

.form-button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}


.error {
  color: red;
  font-size: 0.9em;
  margin-top: 5px;
}
</style>
