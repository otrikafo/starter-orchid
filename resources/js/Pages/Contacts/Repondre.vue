<template>
  <div>
    <h1>Répondre au message du visiteur</h1>

    <p><strong>Visiteur:</strong> {{ contact.visiteur.email }}</p>
    <p><strong>Message original:</strong> {{ contact.message }}</p>

    <form @submit.prevent="submit">
      <div>
        <label for="reponse">Votre réponse</label>
        <textarea id="reponse" v-model="form.reponse"></textarea>
        <div v-if="form.errors.reponse" class="error">{{ form.errors.reponse }}</div>
      </div>
      <button type="submit" :disabled="form.processing">Envoyer la réponse</button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  contact: Object,
});

const form = useForm({
  reponse: '',
});

const submit = () => {
  form.post(route('agence.contacts.reponse.store', { contact: props.contact.id }));
};
</script>

<style scoped>
.error {
  color: red;
  font-size: 0.8em;
}
</style>
