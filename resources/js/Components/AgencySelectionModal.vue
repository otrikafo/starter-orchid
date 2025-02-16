<template>
    <div class="modal-backdrop">
        <div class="modal">
            <div class="modal-header">
                <h2>Sélectionner une Agence</h2>
                <button @click="$emit('close')" class="close-button">&times;</button>
            </div>
            <div class="modal-body">
                <div v-if="loadingAgencies" class="loading-agencies">Chargement des agences...</div>
                <div v-else-if="agencies && agencies.length > 0" class="agencies-list">
                    <div v-for="agence in agencies" :key="agence.id" class="agence-card">
                        <label>
                            <input type="radio" name="agence" :value="agence.id" v-model="selectedAgenceId">
                            {{ agence.raison_sociale }}
                        </label>
                    </div>
                </div>
                <div v-else class="no-agencies">
                    <p>Aucune agence disponible pour le chat pour le moment.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button @click="startChat" :disabled="!selectedAgenceId" class="start-chat-modal-button">Démarrer le Chat</button>
                <button @click="$emit('close')" class="cancel-button">Annuler</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const emit = defineEmits(['close', 'agency-selected']);

const agencies = ref(null);
const loadingAgencies = ref(false);
const selectedAgenceId = ref(null);

const fetchAgencies = async () => {
    loadingAgencies.value = true;
    try {
        const response = await axios.get('/agencies-for-chat'); // Endpoint API pour récupérer les agences
        agencies.value = response.data;
    } catch (error) {
        console.error('Erreur lors de la récupération des agences:', error);
        agencies.value = []; // En cas d'erreur, afficher "Aucune agence disponible"
    } finally {
        loadingAgencies.value = false;
    }
};

const startChat = () => {
    if (selectedAgenceId.value) {
        emit('agency-selected', selectedAgenceId.value); // Émettre l'événement 'agency-selected' avec l'ID de l'agence
    }
};

onMounted(() => {
    fetchAgencies(); // Charger les agences au montage du modal
});
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Assurer que le modal est au-dessus du reste */
}

.modal {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 500px; /* Ajustez la largeur selon vos besoins */
    max-width: 90%;
    overflow: hidden; /* Pour border-radius sur header et footer */
}

.modal-header, .modal-footer {
    padding: 15px 20px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    justify-content: flex-end; /* Aligner les boutons à droite */
}


.modal-header h2 {
    margin: 0;
    font-size: 1.2em;
}

.close-button {
    background: none;
    border: none;
    font-size: 1.5em;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s;
}

.close-button:hover {
    opacity: 1;
}

.modal-body {
    padding: 20px;
}

.loading-agencies, .no-agencies {
    text-align: center;
    color: #777;
    margin-top: 15px;
}

.agencies-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
}

.agence-card {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
}

.agence-card label {
    display: flex;
    align-items: center;
    gap: 10px;
}

.agence-card input[type="radio"] {
    margin: 0;
}

.start-chat-modal-button, .cancel-button {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    margin-left: 10px; /* Espacement entre les boutons */
}

.start-chat-modal-button {
    background-color: #007bff;
    color: white;
}

.start-chat-modal-button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}


.cancel-button {
    background-color: #ddd;
    color: #333;
}
</style>
