<script setup lang="ts">
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { Settings } from 'lucide-vue-next';

  useHead({ title: 'Settings' });

  const breadcrumbs: Breadcrumbs = [{ title: 'Settings', icon: Settings }];
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4">Settings Section</div>
  </PageWrapper>
</template>
