<script setup lang="ts">
  import { sidebarOptions } from '@/types/sidebar';
  import { ChevronDown, ChevronUp, User } from 'lucide-vue-next';

  const { logout } = useSanctumAuth();

  const signOut = async () => {
    await logout();
    window.location.reload();
  };
</script>

<template>
  <Sidebar collapsible="icon">
    <!-- Hidden for now on collapse but want to show icon of workspace instead-->
    <SidebarHeader class="mt-2 group-data-[collapsible=icon]:hidden">
      <SidebarMenu>
        <SidebarMenuItem>
          <DropdownMenu>
            <!--eslint-disable-next-line vue/attribute-hyphenation -->
            <DropdownMenuTrigger asChild>
              <SidebarMenuButton>
                Default Workspace
                <ChevronDown class="ml-auto" />
              </SidebarMenuButton>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-48">
              <DropdownMenuItem>
                <span>Personal Website</span>
              </DropdownMenuItem>
              <DropdownMenuItem>
                <span>Work</span>
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent class="group-data-[collapsible=icon]:mt-1.5">
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

    <SidebarFooter>
      <SidebarMenu>
        <SidebarMenuItem>
          <DropdownMenu>
            <!--eslint-disable-next-line vue/attribute-hyphenation -->
            <DropdownMenuTrigger asChild>
              <SidebarMenuButton>
                <User />
                Username
                <ChevronUp class="ml-auto" />
              </SidebarMenuButton>
            </DropdownMenuTrigger>
            <DropdownMenuContent side="top" class="w-48">
              <DropdownMenuItem>
                <NuxtLink to="/profile">Profile</NuxtLink>
              </DropdownMenuItem>
              <DropdownMenuItem @click="signOut">
                <span>Sign out</span>
              </DropdownMenuItem>
            </DropdownMenuContent>
          </DropdownMenu>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarFooter>
  </Sidebar>
</template>
