<script setup lang="ts">
  import { CircleUser, Home, Settings } from 'lucide-vue-next';

  const items = [
    {
      title: 'Home',
      url: '/home',
      icon: Home,
    },
    {
      title: 'Standup',
      url: '/standup',
      icon: CircleUser,
    },
    {
      title: 'Settings',
      url: '/settings',
      icon: Settings,
    },
  ];
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
            <SidebarMenuItem v-for="item in items" :key="item.title">
              <SidebarMenuButton as-child>
                <a :href="item.url">
                  <component :is="item.icon" />
                  <span>{{ item.title }}</span>
                </a>
              </SidebarMenuButton>
            </SidebarMenuItem>
          </SidebarMenu>
        </SidebarGroupContent>
      </SidebarGroup>
    </SidebarContent>
  </Sidebar>
</template>
