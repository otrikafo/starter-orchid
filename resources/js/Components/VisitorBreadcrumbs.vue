<template>
    <div class="breadcrumbs">
        <template v-for="(breadcrumb, index) in breadcrumbs" :key="index">
            <Link :href="route(breadcrumb.route, breadcrumb.params)" class="breadcrumb-item" :class="{ 'active': breadcrumb.active }">
                {{ breadcrumb.label }}
            </Link>
            <span class="breadcrumb-separator" v-if="index < breadcrumbs.length - 1">/</span>
        </template>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    home: {
        type: Object,
        default: null,
    },
    breadcrumbs: {
        type: Array,
        default: () => [],
    },
});
</script>

<style scoped>
.breadcrumbs {
    display: flex;
    align-items: center;
    font-size: 0.9em;
    color: #666;
    margin: 2em;
}

.breadcrumb-item {
    text-decoration: none;
    color: #007bff; /* Couleur des liens */
    transition: color 0.3s ease;
}

.breadcrumb-item:hover {
    color: #0056b3; /* Couleur au survol */
}

.breadcrumb-item.active {
    color: #333; /* Couleur de l'élément actif (page courante) */
    pointer-events: none; /* Désactiver les clics sur l'élément actif */
}

.breadcrumb-separator {
    margin: 0 5px;
    color: #999; /* Couleur des séparateurs */
}

.home-breadcrumb {
    font-weight: bold; /* Mettre le lien "Accueil" en gras */
}
</style>
