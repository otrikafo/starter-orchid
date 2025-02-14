<template>
  <div class="avis-agence-form">
    <h3>Laisser un avis sur cette agence</h3>
    <form @submit.prevent="submit">
      <div>
        <label for="note">Note (sur 5)</label>
        <select id="note" v-model.number="form.note">
          <option value="1">1 - Très mauvais</option>
          <option value="2">2 - Mauvais</option>
          <option value="3">3 - Moyen</option>
          <option value="4">4 - Bon</option>
          <option value="5">5 - Excellent</option>
        </select>
        <div v-if="form.errors.note" class="error">{{ form.errors.note }}</div>
      </div>
      <div>
        <label for="commentaire">Commentaire</label>
        <textarea id="commentaire" v-model="form.commentaire" rows="4"></textarea>
        <div v-if="form.errors.commentaire" class="error">{{ form.errors.commentaire }}</div>
      </div>
      <button type="submit" :disabled="form.processing">Envoyer l'avis</button>
    </form>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  agenceId: {
    type: Number,
    required: true,
  },
});

const form = useForm({
  note: 3, // Note par défaut à 3 (Moyen)
  commentaire: '',
});

const submit = () => {
    console.log(props.agenceId);

  form.post(route('agences.avis.store', { agence: props.agenceId }), {
    onSuccess: () => {
      form.reset(); // Réinitialise le formulaire après succès
      // Optionnellement, afficher un message de succès à l'utilisateur
      alert('Merci pour votre avis !');
      // Optionnellement, recharger la page pour afficher l'avis immédiatement
      // Inertia.reload({ only: ['agence'] }); // Si vous voulez recharger seulement la prop 'agence'
    },
  });
};
</script>

<style scoped>
.avis-agence-form {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

.avis-agence-form h3 {
  margin-top: 0;
  margin-bottom: 15px;
  font-size: 1.3em;
  color: #333;
}

.avis-agence-form div {
  margin-bottom: 15px;
}

.avis-agence-form label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #555;
}

.avis-agence-form select,
.avis-agence-form textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  font-family: inherit; /* Hérite de la police du parent */
  font-size: 1em;
}

.avis-agence-form textarea {
  resize: vertical; /* Permettre la redimension verticale du textarea */
}

.avis-agence-form button {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
  transition: background-color 0.2s ease;
}

.avis-agence-form button:hover {
  background-color: #0056b3;
}

.avis-agence-form button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}


.error {
  color: red;
  font-size: 0.9em;
  margin-top: 4px;
}
</style>
