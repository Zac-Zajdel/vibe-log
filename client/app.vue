<script setup lang="ts">
  import { VueQueryDevtools } from '@tanstack/vue-query-devtools';
  import 'vue-sonner/style.css';

  const colorMode = useColorMode();
  const { isAuthenticated } = useSanctumAuth();

  const theme = ref(colorMode.value as 'light' | 'dark');

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
    <ClientOnly>
      <Toaster richColors closeButton :theme="theme" />
    </ClientOnly>
  </div>
</template>
