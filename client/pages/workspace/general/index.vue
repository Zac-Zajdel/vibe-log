<script setup lang="ts">
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { Box, FileBox } from 'lucide-vue-next';

  useHead({ title: 'Workspace Settings' });

  const breadcrumbs: Breadcrumbs = [
    { title: 'Workspace', icon: Box },
    { title: 'General', icon: FileBox },
  ];
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4">Workspace Settings Form For Now....</div>
  </PageWrapper>
</template>
