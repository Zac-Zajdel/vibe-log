<script setup lang="ts">
  import AppSidebarFooter from '@/components/ui/sidebar/AppSidebarFooter.vue';
  import AppSidebarHeader from '@/components/ui/sidebar/AppSidebarHeader.vue';
  import { sidebarOptions } from '@/types/sidebar';
  import { ChevronRight } from 'lucide-vue-next';

  const openStates = ref<Record<string, boolean>>({});

  const toggleItem = (title: string) => {
    openStates.value[title] = !openStates.value[title];
  };
</script>

<template>
  <Sidebar collapsible="icon">
    <AppSidebarHeader class="mt-2" />

    <SidebarContent class="group-data-[collapsible=icon]:mt-1.5">
      <Separator class="mt-1" />
      <SidebarGroup>
        <SidebarGroupContent>
          <SidebarMenu>
            <template v-for="option in sidebarOptions" :key="option.title">
              <template v-if="option.subItems">
                <Collapsible
                  :open="openStates[option.title]"
                  class="group/collapsible"
                  @update:open="toggleItem(option.title)"
                >
                  <SidebarMenuItem>
                    <CollapsibleTrigger asChild>
                      <SidebarMenuButton asChild>
                        <div class="flex cursor-pointer justify-between">
                          <div class="flex items-center">
                            <component :is="option.icon" :size="17" />
                            <span class="pl-2">{{ option.title }}</span>
                          </div>
                          <ChevronRight
                            class="transition-transform duration-200 ease-in-out"
                            :class="
                              openStates[option.title] ? 'rotate-90' : null
                            "
                          />
                        </div>
                      </SidebarMenuButton>
                    </CollapsibleTrigger>
                    <CollapsibleContent>
                      <SidebarMenuSub>
                        <SidebarMenuSubItem
                          v-for="item in option.subItems"
                          :key="item.title"
                          class="cursor-pointer py-0.5"
                        >
                          <SidebarMenuSubButton>
                            <NuxtLink :to="item.url" class="flex items-center">
                              <span>{{ item.title }}</span>
                            </NuxtLink>
                          </SidebarMenuSubButton>
                        </SidebarMenuSubItem>
                      </SidebarMenuSub>
                    </CollapsibleContent>
                  </SidebarMenuItem>
                </Collapsible>
              </template>
              <template v-else>
                <SidebarMenuItem>
                  <SidebarMenuButton as-child>
                    <NuxtLink :to="option.url">
                      <component :is="option.icon" />
                      <span>{{ option.title }}</span>
                    </NuxtLink>
                  </SidebarMenuButton>
                </SidebarMenuItem>
              </template>
            </template>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>

    <AppSidebarFooter />
  </Sidebar>
</template>
