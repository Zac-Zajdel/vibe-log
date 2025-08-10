<script setup lang="ts">
  import { sidebarOptions } from '@/types/sidebar';
</script>

<template>
  <Sidebar collapsible="icon">
    <SidebarContent class="group-data-[collapsible=icon]:mt-1.5">
      <SidebarGroup>
        <SidebarGroupContent>
          <SidebarMenu>
            <template v-for="option in sidebarOptions" :key="option.title">
              <TooltipProvider>
                <Tooltip>
                  <TooltipTrigger as-child>
                    <SidebarMenuItem>
                      <SidebarMenuButton as-child>
                        <NuxtLink :to="option.url">
                          <component :is="option.icon" />
                          <span>{{ option.title }}</span>
                        </NuxtLink>
                      </SidebarMenuButton>
                    </SidebarMenuItem>
                  </TooltipTrigger>
                  <TooltipContent side="right">
                    <p>{{ option.title }}</p>
                  </TooltipContent>
                </Tooltip>
              </TooltipProvider>
            </template>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
  </Sidebar>
</template>
