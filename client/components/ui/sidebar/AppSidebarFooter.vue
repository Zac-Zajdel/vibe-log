<script setup lang="ts">
  import { useUser } from '@/hooks/authentication/useUser';
  import { ChevronUp, User } from 'lucide-vue-next';

  const user = useUser();
  const { logout } = useSanctumAuth();

  const signOut = async () => {
    await logout();
    window.location.reload();
  };
</script>

<template>
  <div>
    <Separator />
    <SidebarFooter>
      <SidebarMenu>
        <SidebarMenuItem>
          <DropdownMenu>
            <DropdownMenuTrigger
              size="group-data-[collapsible=icon]:lg"
              asChild
            >
              <SidebarMenuButton class="flex items-center">
                <User />
                <div
                  class="ml-1 flex w-26 flex-col group-data-[collapsible=icon]:hidden"
                >
                  <span class="truncate text-xs font-medium">
                    {{ user?.data?.name }}
                  </span>
                  <span class="text-muted-foreground truncate text-[10px]">
                    {{ user?.data?.email }}
                  </span>
                </div>
                <ChevronUp
                  class="ml-auto group-data-[collapsible=icon]:hidden"
                />
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
  </div>
</template>
