<script setup lang="ts">
  import { VueQueryDevtools } from '@tanstack/vue-query-devtools';

  const { isAuthenticated } = useSanctumAuth();

  const layout = ref('default');
  if (isAuthenticated.value) {
    layout.value = 'sidebar';
  }

  watch(isAuthenticated, (newVal) => {
    if (newVal) {
      layout.value = 'sidebar';
    } else {
      layout.value = 'default';
    }
  });
</script>

<template>
  <div>
    <NuxtLayout :name="layout">
      <NuxtPage />
    </NuxtLayout>
    <VueQueryDevtools />
  </div>
</template>
