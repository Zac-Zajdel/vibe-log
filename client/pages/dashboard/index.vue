<script setup lang="ts">
  definePageMeta({
    middleware: ['$auth'],
  });

  const { logout } = useSanctum();
  const colorMode = useColorMode();

  const data = await useSanctumFetch('/api/hello');

  const logoutUser = () => logout();
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold">Dashboard</h1>

    <div class="flex flex-col gap-4">
      <NuxtLink to="/">Home</NuxtLink>

      <code>{{ data }}</code>

      <div class="flex gap-2">
        <Button @click="colorMode.preference = 'light'">Light</Button>
        <Button @click="colorMode.preference = 'dark'">Dark</Button>
        <Button @click="colorMode.preference = 'system'">System</Button>
        <Button @click="logoutUser">Logout</Button>
      </div>
    </div>
  </div>
</template>
