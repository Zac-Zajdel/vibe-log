<script setup lang="ts">
  import { VueQueryDevtools } from '@tanstack/vue-query-devtools';

  // TODO - this appears to not be reactive?
  const { isAuthenticated } = useSanctumAuth();

  let layout = 'default';
  if (isAuthenticated.value) {
    layout = 'sidebar';
  }
</script>

<template>
  <div>
    <NuxtLayout :name="layout">
      <NuxtPage />
    </NuxtLayout>
    <VueQueryDevtools />
  </div>
</template>
