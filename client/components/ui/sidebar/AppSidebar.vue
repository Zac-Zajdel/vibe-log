<script setup lang="ts">
  import { sidebarOptions } from '@/types/sidebar';
</script>

<template>
  <Sidebar collapsible="icon">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton class="h-13" as-child>
            <NuxtLink href="/home">
              <AppLogo />
            </NuxtLink>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent class="mt-1">
      <SidebarGroup>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem
              v-for="option in sidebarOptions"
              :key="option.title"
            >
              <SidebarMenuButton as-child>
                <NuxtLink :href="option.url">
                  <component :is="option.icon" />
                  <span>{{ option.title }}</span>
                </NuxtLink>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
  </Sidebar>
</template>
