<script setup lang="ts">
  import { Button } from '@/components/ui/button';
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu';
  import { useDestroyWorkspaceUserMutation } from '@/hooks/api/workspaceUser/useDestroyWorkspaceUserMutation';
  import { useUser } from '@/hooks/authentication/useUser';
  import { useQueryClient } from '@tanstack/vue-query';
  import { MoreHorizontal, Trash } from 'lucide-vue-next';
  import { toast } from 'vue-sonner';

  const props = defineProps<{
    workspaceUser: App.Data.Resource.WorkspaceUser.WorkspaceUserResource;
  }>();

  const user = useUser();
  const queryClient = useQueryClient();
  const destroyWorkspaceUserMutation = useDestroyWorkspaceUserMutation();

  const isDisabled = computed(
    () => user.value?.id === props.workspaceUser.user_id
  );

  const deleteUser = () => {
    destroyWorkspaceUserMutation.mutateAsync(props.workspaceUser.id, {
      onSuccess: async ({ message }: { message: string }) => {
        toast.success(message);

        queryClient.invalidateQueries({
          queryKey: ['workspace-users'],
        });
      },
    });
  };
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button :disabled="isDisabled" variant="ghost" class="size-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="size-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuItem @click="deleteUser">
        <Trash />
        Delete
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>

<style scoped>
  button:disabled,
  button[disabled] {
    cursor: not-allowed !important;
  }
</style>
