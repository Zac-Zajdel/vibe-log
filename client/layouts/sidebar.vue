<script setup lang="ts">
  import NavBar from '@/components/global/NavBar.vue';

  const defaultOpen = useCookie<boolean>('sidebar_state');
</script>

<template>
  <div>
    <NavBar />
    <SidebarProvider :default-open="defaultOpen" class="flex-col">
      <div class="flex flex-1">
        <AppSidebar />
        <main class="flex-1">
          <slot />
        </main>
      </div>
    </SidebarProvider>
  </div>
</template>
