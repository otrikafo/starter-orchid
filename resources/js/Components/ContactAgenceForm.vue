<template>
  <div class="contact-form-container">
    <h2 class="contact-form-title">Contacter l'agence</h2>
    <form @submit.prevent="submit" class="contact-form">
      <div class="form-group">
        <label for="message" class="form-label">Votre message</label>
        <textarea
          id="message"
          v-model="form.message"
          class="form-textarea"
          placeholder="Saisissez votre message ici..."
        ></textarea>
        <div v-if="form.errors.message" class="error">{{ form.errors.message }}</div>
      </div>
      <button type="submit" class="form-button":disabled="form.processing">
        Envoyer le message
      </button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  bienId: String,
  agenceId: String, // Ajout de agenceId en props
});

const form = useForm({
  message: '',
});

const submit = () => {
  form.post(route('biens.contact.agence', { bien: props.bienId }));
};
</script>

<style scoped>.contact-form-container {
  background-color: #fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  margin: 20px auto;
}.contact-form-title {
  font-size: 1.8em;
  color: #333;
  margin-top: 0;
  margin-bottom: 20px;
  text-align: center;
}.contact-form {
  display: flex;
  flex-direction: column;
}.form-group {
  margin-bottom: 20px;
}.form-label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
  color: #555;
}.form-textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-family: inherit;
  font-size: 1em;
  resize: vertical; /* Allow vertical resizing */
  box-sizing: border-box; /* Prevent padding from increasing overall width */
}.form-textarea:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}.form-button {
  padding: 12px 25px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1em;
  font-weight: bold;
  transition: background-color 0.2s ease;
}.form-button:hover {
  background-color: #0056b3;
}.form-button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}.error {
  color: red;
  font-size: 0.9em;
  margin-top: 5px;
}
</style>
