<script setup lang="ts">
  const defaultOpen = useCookie<boolean>('sidebar_state');
</script>

<template>
  <SidebarProvider :default-open="defaultOpen">
    <AppSidebar />
    <main class="flex-1">
      <slot />
    </main>
  </SidebarProvider>
</template>
