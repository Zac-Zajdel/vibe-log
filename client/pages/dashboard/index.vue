<script setup lang="ts">
  import { useQuery } from '@tanstack/vue-query';

  definePageMeta({
    middleware: ['sanctum:auth'],
  });

  const { logout } = useSanctumAuth();
  const colorMode = useColorMode();

  const { isPending, data } = useQuery({
    queryKey: ['hello'],
    queryFn: () => useSanctumFetch('/api/hello'),
  });

  const logoutUser = () => logout();
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold">Dashboard</h1>

    <div class="flex flex-col gap-4">
      <div v-if="isPending">Loading...</div>
      <code v-else>{{ data }}</code>

      <div class="flex gap-2">
        <Button @click="colorMode.preference = 'light'">Light</Button>
        <Button @click="colorMode.preference = 'dark'">Dark</Button>
        <Button @click="colorMode.preference = 'system'">System</Button>
        <Button @click="logoutUser">Logout</Button>
      </div>
    </div>
  </div>
</template>
