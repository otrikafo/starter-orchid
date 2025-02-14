<template>
  <div>
    <h1>Inscription Agence</h1>

    <div class="tab-container">

      <button
        class="tab login-tab"
        @click="redirectToLogin"
      >
        Vous avez déjà un compte ?
      </button>
      <button
        class="tab active"
        :class="{ 'active': activeTab === 'register' }"
        @click="activeTab = 'register'"
      >
        Dévenir agence
      </button>
    </div>

    <form v-if="activeTab === 'register'" @submit.prevent="submit" class="register-form">
      <div>
        <label for="raison_sociale">Raison Sociale</label>
        <input type="text" id="raison_sociale" v-model="form.raison_sociale">
        <div v-if="form.errors.raison_sociale" class="error">{{ form.errors.raison_sociale }}</div>
      </div>
      <div>
        <label for="siege">Siège</label>
        <input type="text" id="siege" v-model="form.siege">
        <div v-if="form.errors.siege" class="error">{{ form.errors.siege }}</div>
      </div>
      <div>
        <label for="nif">NIF</label>
        <input type="text" id="nif" v-model="form.nif">
        <div v-if="form.errors.nif" class="error">{{ form.errors.nif }}</div>
      </div>
      <div>
        <label for="stat">STAT</label>
        <input type="text" id="stat" v-model="form.stat">
        <div v-if="form.errors.stat" class="error">{{ form.errors.stat }}</div>
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" v-model="form.email">
        <div v-if="form.errors.email" class="error">{{ form.errors.email }}</div>
      </div>
      <div>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" v-model="form.password">
        <div v-if="form.errors.password" class="error">{{ form.errors.password }}</div>
      </div>
      <div>
        <label for="password_confirmation">Confirmation Mot de passe</label>
        <input type="password" id="password_confirmation" v-model="form.password_confirmation">
      </div>
      <button type="submit" :disabled="form.processing">S'inscrire</button>
    </form>
  </div>
</template>
<script setup>
import { useForm, router } from '@inertiajs/vue3';
import AgenceLayout from '@/Layouts/AgenceLayout.vue';
import { ref } from 'vue';

defineOptions({
  layout: AgenceLayout,
});

const activeTab = ref('register'); // 'register' or 'login' (but login is just a link)

const form = useForm({
    raison_sociale: '',
    siege: '',
    nif: '',
    stat: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/agence/inscription', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.log(errors);
            form.errors = errors;
        },
    });
};

const redirectToLogin = () => {
  router.get(route('agence.connexion')); // Assuming you have a route named 'agence.connexion'
};
</script>

<style scoped>
.tab-container {
  display: flex;
  margin-bottom: 20px;
  border-bottom: 2px solid #ddd;
}

.tab {
  padding: 10px 15px;
  border: none;
  background-color: transparent;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  margin-right: 10px;
  font-weight: bold;
  color: #555;
}

.tab:hover {
  color: #333;
}

.tab.active {
  border-bottom: 2px solid #007bff; /* Couleur active */
  color: #007bff;
}

.login-tab {
    color: #007bff; /* Couleur distinctive pour "Vous avez déjà un compte ?" */
}

.login-tab:hover {
    text-decoration: underline;
}


.register-form {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.register-form div {
  margin-bottom: 15px;
}

.register-form label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.register-form input[type="text"],
.register-form input[type="email"],
.register-form input[type="password"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; /* Important pour que padding ne déborde pas */
}

.register-form button {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.register-form button:hover {
  background-color: #0056b3;
}

.register-form button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}


.error {
  color: red;
  font-size: 0.8em;
  margin-top: 4px;
}
</style>
