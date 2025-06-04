<script setup lang="ts">
  import { LogIn } from 'lucide-vue-next';
</script>

<template>
  <div class="flex items-center justify-between pt-5 pb-3">
    <div class="flex items-center">
      <h1 class="ml-4 text-2xl">Vibe Log</h1>
    </div>
    <NuxtLink to="/login">
      <Button iconPlacement="right" effect="expandIcon" :icon="LogIn">
        Login
      </Button>
    </NuxtLink>
  </div>
</template>
