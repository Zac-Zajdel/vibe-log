<script setup lang="ts">
  import { ChevronUp, User } from 'lucide-vue-next';

  const { logout } = useSanctumAuth();

  const signOut = async () => {
    await logout();
    window.location.reload();
  };
</script>

<template>
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
            <DropdownMenuItem class="text-xs">
              <NuxtLink to="/profile">Profile</NuxtLink>
            </DropdownMenuItem>
            <DropdownMenuItem class="text-xs" @click="signOut">
              <span>Sign out</span>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarFooter>
</template>
