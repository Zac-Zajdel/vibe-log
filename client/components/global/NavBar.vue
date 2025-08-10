<script lang="ts" setup>
  import { useUpdateUserMutation } from '@/hooks/api/user/useUpdateUserMutation';
  import { useWorkspacesQuery } from '@/hooks/api/workspace/useWorkspacesQuery';
  import { useUser } from '@/hooks/authentication/useUser';
  import { useQueryClient } from '@tanstack/vue-query';
  import { ChevronsDown, House } from 'lucide-vue-next';
  import { toast } from 'vue-sonner';

  const user = useUser();
  const queryClient = useQueryClient();
  const { refreshIdentity, logout } = useSanctumAuth();
  const updateUserMutation = useUpdateUserMutation();

  const { workspaces } = useWorkspacesQuery({
    search: ref(''),
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
  <div class="flex max-h-13 justify-between border-b p-3">
    <div class="flex items-center">
      <!-- This will be the icon of the app-->
      <NuxtLink to="/">
        <Button variant="ghost" size="icon" class="-ml-1 size-8">
          <House class="size-4" />
        </Button>
      </NuxtLink>

      <span class="text-muted-foreground/50 mx-2 rotate-20 text-sm">/</span>
      <DropdownMenu>
        <DropdownMenuTrigger asChild>
          <div class="flex w-64 items-center overflow-hidden">
            <Button variant="ghost" size="sm">
              <span class="block truncate text-xs font-medium">
                {{ user.active_workspace?.name || 'Default Workspace' }}
              </span>
              <ChevronsDown class="size-4" />
            </Button>
          </div>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="w-66">
          <input
            placeholder="Search..."
            class="hover:bg-secondary w-full rounded-md border-none bg-transparent px-2 py-1 text-sm shadow-none placeholder:text-xs focus:ring-0 focus:outline-none"
            @keydown.stop
            @keyup.stop
            @keypress.stop
          />
          <DropdownMenuItem
            v-for="workspace in workspaces"
            :key="workspace.id"
            class="text-xs"
            @click="handleWorkspaceChange(workspace.id)"
          >
            <span>{{ workspace.name }}</span>
          </DropdownMenuItem>
          <WorkspaceCreate />
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
    <DropdownMenu>
      <DropdownMenuTrigger asChild>
        <Avatar>
          <AvatarImage
            src="https://lh3.googleusercontent.com/a/ACg8ocKZZZrmr_-5RzYFCftYs7wcTBA_abHTBodJXsB-nE5E20oC2WU0=s96-c"
            alt="@unovue"
          />
          <AvatarFallback>ZZ</AvatarFallback>
        </Avatar>
      </DropdownMenuTrigger>
      <DropdownMenuContent side="top" class="w-48">
        <DropdownMenuItem class="text-xs">
          <NuxtLink to="/profile">Profile</NuxtLink>
        </DropdownMenuItem>
        <DropdownMenuItem class="text-xs" @click="() => logout()">
          <span>Sign out</span>
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  </div>
</template>
