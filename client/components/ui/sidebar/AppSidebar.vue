<script setup lang="ts">
  import AppSidebarFooter from '@/components/ui/sidebar/AppSidebarFooter.vue';
  import AppSidebarHeader from '@/components/ui/sidebar/AppSidebarHeader.vue';
  import { sidebarOptions } from '@/types/sidebar';
</script>

<template>
  <Sidebar collapsible="icon">
    <AppSidebarHeader />

    <SidebarContent class="group-data-[collapsible=icon]:mt-1.5">
      <Separator class="mt-1" />
      <SidebarGroup>
        <SidebarGroupContent>
          <SidebarMenu>
            <SidebarMenuItem
              v-for="option in sidebarOptions"
              :key="option.title"
            >
              <SidebarMenuButton as-child>
                <NuxtLink :to="option.url">
                  <component :is="option.icon" />
                  <span>{{ option.title }}</span>
                </NuxtLink>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>

    <AppSidebarFooter />
  </Sidebar>
</template>
