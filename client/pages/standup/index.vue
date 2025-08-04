<script setup lang="ts">
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { PersonStanding } from 'lucide-vue-next';

  useHead({ title: 'Standup' });

  const breadcrumbs: Breadcrumbs = [{ title: 'Standup', icon: PersonStanding }];
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4">Standup Section</div>
  </PageWrapper>
</template>
