<script setup lang="ts">
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { useQuery } from '@tanstack/vue-query';
  import { HomeIcon } from 'lucide-vue-next';

  const colorMode = useColorMode();

  const { isPending, data } = useQuery({
    queryKey: ['hello'],
    queryFn: () => useSanctumFetch('/api/v1/hello'),
  });

  const breadcrumbs: Breadcrumbs = [{ title: 'Home', icon: HomeIcon }];
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4">
      <div v-if="isPending">Loading...</div>
      <code v-else>{{ data }}</code>

      <div class="flex gap-2">
        <Button @click="colorMode.preference = 'light'">Light</Button>
        <Button @click="colorMode.preference = 'dark'">Dark</Button>
        <Button @click="colorMode.preference = 'system'">System</Button>
      </div>
    </div>
  </PageWrapper>
</template>
