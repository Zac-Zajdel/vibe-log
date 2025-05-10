<script setup lang="ts">
  definePageMeta({
    middleware: ['$auth'],
  });

  const colorMode = useColorMode();
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold">Dashboard</h1>

    <div class="flex flex-col gap-4">
      <NuxtLink to="/">Home</NuxtLink>

      <div class="flex gap-2">
        <Button @click="colorMode.preference = 'light'">Light</Button>
        <Button @click="colorMode.preference = 'dark'">Dark</Button>
        <Button @click="colorMode.preference = 'system'">System</Button>
      </div>
    </div>
  </div>
</template>
