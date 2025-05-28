<script setup lang="ts">
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { HomeIcon } from 'lucide-vue-next';

  useHead({ title: 'Home' });

  const colorMode = useColorMode();

  const breadcrumbs: Breadcrumbs = [{ title: 'Home', icon: HomeIcon }];
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4">
      <div class="flex gap-2">
        <Button @click="colorMode.preference = 'light'">Light</Button>
        <Button @click="colorMode.preference = 'dark'">Dark</Button>
        <Button @click="colorMode.preference = 'system'">System</Button>
      </div>
    </div>
  </PageWrapper>
</template>
