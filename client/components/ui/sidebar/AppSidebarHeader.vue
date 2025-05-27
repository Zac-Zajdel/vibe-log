<script setup lang="ts">
  import { useWorkspacesQuery } from '@/hooks/api/workspace/useWorkspacesQuery';
  import { useUser } from '@/hooks/authentication/useUser';
  import { ChevronDown } from 'lucide-vue-next';

  const user = useUser();

  const { workspaces } = useWorkspacesQuery(1, 10);
</script>

<template>
  <!-- TODO: When collapsed, we just display the workspace icon -->
  <SidebarHeader class="mt-2 group-data-[collapsible=icon]:hidden">
    <SidebarMenu>
      <SidebarMenuItem>
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <SidebarMenuButton
              :tooltip="
                user?.data?.active_workspace?.name || 'Default Workspace'
              "
            >
              <div class="w-33 overflow-hidden">
                <span class="block truncate text-xs font-medium">
                  {{
                    user?.data?.active_workspace?.name || 'Default Workspace'
                  }}
                </span>
              </div>
              <ChevronDown class="ml-auto" />
            </SidebarMenuButton>
          </DropdownMenuTrigger>
          <DropdownMenuContent class="w-48">
            <DropdownMenuItem
              v-for="workspace in workspaces"
              :key="workspace.id"
              class="text-xs"
            >
              <span>{{ workspace.name }}</span>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarHeader>
</template>
