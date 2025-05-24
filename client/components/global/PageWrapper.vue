<script lang="ts" setup>
  import type { Breadcrumbs } from '@/types/breadcrumbs';

  defineProps<{ breadcrumbs?: Breadcrumbs }>();
</script>

<template>
  <div>
    <NavBar :breadcrumbs="breadcrumbs" />
    <div class="p-4">
      <slot />
    </div>
  </div>
</template>
