<script setup lang="ts">
  import { useUpdateUserMutation } from '@/hooks/api/user/useUpdateUserMutation';
  import { useWorkspacesQuery } from '@/hooks/api/workspace/useWorkspacesQuery';
  import { useUser } from '@/hooks/authentication/useUser';
  import { useQueryClient } from '@tanstack/vue-query';
  import { useDebounce } from '@vueuse/core';
  import { ChevronDown } from 'lucide-vue-next';
  import { toast } from 'vue-sonner';

  const user = useUser();
  const queryClient = useQueryClient();
  const { refreshIdentity } = useSanctumAuth();
  const updateUserMutation = useUpdateUserMutation();

  const search = ref('');
  const debouncedSearch = useDebounce(search, 300);
  const { workspaces } = useWorkspacesQuery({
    search: debouncedSearch,
  });

  async function handleWorkspaceChange(workspaceId: number) {
    user.value.active_workspace_id = workspaceId;

    updateUserMutation.mutateAsync(user.value, {
      onSuccess: async ({ message }: { message: string }) => {
        toast.success(message);

        // Re-queries the user to get the updated active workspace.
        refreshIdentity();

        // Invalidate all cached queries.
        queryClient.invalidateQueries();
      },
    });
  }
</script>

<template>
  <!-- TODO: When collapsed, we just display the workspace icon -->
  <SidebarHeader class="group-data-[collapsible=icon]:hidden">
    <SidebarMenu>
      <SidebarMenuItem>
        <DropdownMenu>
          <DropdownMenuTrigger asChild>
            <SidebarMenuButton>
              <div class="w-33 overflow-hidden">
                <span class="block truncate text-xs font-medium">
                  {{ user.active_workspace?.name || 'Default Workspace' }}
                </span>
              </div>
              <ChevronDown class="ml-auto" />
            </SidebarMenuButton>
          </DropdownMenuTrigger>
          <DropdownMenuContent class="w-48">
            <input
              v-model="search"
              placeholder="Search..."
              class="hover:bg-secondary w-full rounded-md border-none bg-transparent px-2 py-1 text-sm shadow-none placeholder:text-xs focus:ring-0 focus:outline-none"
              @keydown.stop
              @keyup.stop
              @keypress.stop
            />
            <SidebarSeparator class="mx-0 my-1" />
            <DropdownMenuItem
              v-for="workspace in workspaces"
              :key="workspace.id"
              class="text-xs"
              @click="handleWorkspaceChange(workspace.id)"
            >
              <span>{{ workspace.name }}</span>
            </DropdownMenuItem>
            <SidebarSeparator class="mx-0 my-1" />
            <WorkspaceCreate />
          </DropdownMenuContent>
        </DropdownMenu>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarHeader>
</template>
