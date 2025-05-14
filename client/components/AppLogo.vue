<script setup lang="ts">
  import { Trophy } from 'lucide-vue-next';
</script>

<template>
  <div
    class="bg-primary text-primary-foreground flex aspect-square size-8 items-center justify-center rounded-md"
  >
    <Trophy :size="18" />
  </div>
  <div class="ml-1 grid flex-1 text-left text-sm">
    <span class="mb-0.5 truncate leading-none font-semibold">Win The Take</span>
  </div>
</template>
