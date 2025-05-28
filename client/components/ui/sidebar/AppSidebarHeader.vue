<script setup lang="ts">
  import { useUpdateUserMutation } from '@/hooks/api/user/useUpdateUserMutation';
  import { useWorkspacesQuery } from '@/hooks/api/workspace/useWorkspacesQuery';
  import { useUser } from '@/hooks/authentication/useUser';
  import { useQueryClient } from '@tanstack/vue-query';
  import { ChevronDown } from 'lucide-vue-next';
  import { toast } from 'vue-sonner';

  const user = useUser();
  const queryClient = useQueryClient();
  const { refreshIdentity } = useSanctumAuth();
  const updateUserMutation = useUpdateUserMutation();

  const { workspaces } = useWorkspacesQuery(1, 10);

  async function handleWorkspaceChange(workspaceId: number) {
    user.value.active_workspace_id = workspaceId;

    updateUserMutation.mutateAsync(user.value, {
      onSuccess: async ({ message }: { message: string }) => {
        toast.success(message);

        // Re-queries the user to get the updated active workspace.
        refreshIdentity();

        // Updates the sidebar options within the dropdown menu.
        queryClient.invalidateQueries({
          queryKey: ['workspaces'],
        });
      },
    });
  }
</script>

<template>
  <!-- TODO: When collapsed, we just display the workspace icon -->
  <SidebarHeader class="mt-2 group-data-[collapsible=icon]:hidden">
    <SidebarMenu>
      <SidebarMenuItem>
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <SidebarMenuButton
              :tooltip="user.active_workspace?.name || 'Default Workspace'"
            >
              <div class="w-33 overflow-hidden">
                <span class="block truncate text-xs font-medium">
                  {{ user.active_workspace?.name || 'Default Workspace' }}
                </span>
              </div>
              <ChevronDown class="ml-auto" />
            </SidebarMenuButton>
          </DropdownMenuTrigger>
          <!-- TODO - Add option for user to create more workspaces either as + icon or as first content within dropdown -->
          <DropdownMenuContent class="w-48">
            <DropdownMenuItem
              v-for="workspace in workspaces"
              :key="workspace.id"
              class="text-xs"
              @click="handleWorkspaceChange(workspace.id)"
            >
              <span>{{ workspace.name }}</span>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarHeader>
</template>
