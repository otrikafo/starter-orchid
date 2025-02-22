<template>
  <div>
    <h1>Connexion Agence</h1>

    <div class="tab-container">
      <button
        class="tab active"
        :class="{ 'active': activeTab === 'login' }"
        @click="activeTab = 'login'"
      >
        Vous avez déjà un compte?
      </button>
      <button
        class="tab register-tab"
        @click="redirectToRegister"
      >
        Dévenir agence ?
      </button>
    </div>

    <form v-if="activeTab === 'login'" @submit.prevent="submit" class="login-form">
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
      <button type="submit" :disabled="form.processing">Se connecter</button>
    </form>
  </div>
</template>

<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import VisitorLayout from '@/Layouts/VisitorLayout.vue';

defineOptions({
  layout: VisitorLayout,
});

const activeTab = ref('login'); // 'login' or 'register' (but register is just a link)

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post('/agence/connexion');
};

const redirectToRegister = () => {
  router.get(route('agence.inscription')); // Assuming you have a route named 'agence.inscription'
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

.register-tab {
    color: #007bff; /* Couleur distinctive pour "Devenir agence ?" */
}

.register-tab:hover {
    text-decoration: underline;
}


.login-form {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
}

.login-form div {
  margin-bottom: 15px;
}

.login-form label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.login-form input[type="email"],
.login-form input[type="password"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box; /* Important pour que padding ne déborde pas */
}

.login-form button {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.login-form button:hover {
  background-color: #0056b3;
}

.login-form button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}


.error {
  color: red;
  font-size: 0.8em;
  margin-top: 4px;
}
</style>
