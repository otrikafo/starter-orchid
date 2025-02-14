<template>
  <div v-if="links.length > 3">
    <div class="pagination">
      <Link v-for="(link, key) in links" :key="key" :href="link.url" :class="{ 'active': link.active, 'disabled': link.url === null }" v-html="link.label" />
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  links: Array,
});
</script>

<style scoped>
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.pagination a {
  padding: 8px 12px;
  margin: 0 5px;
  border: 1px solid #ccc;
  text-decoration: none;
  color: #333;
  border-radius: 4px;
}

.pagination a.active {
  background-color: #007bff;
  color: white;
  border-color: #007bff;
}

.pagination a.disabled {
  color: #999;
  border-color: #ddd;
  pointer-events: none;
}
</style>
