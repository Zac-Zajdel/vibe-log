<script setup lang="ts">
  const defaultOpen = useCookie<boolean>('sidebar_state');
</script>

<template>
  <SidebarProvider :default-open="defaultOpen">
    <AppSidebar />
    <main>
      <SidebarTrigger />
      <slot />
    </main>
  </SidebarProvider>
</template>
