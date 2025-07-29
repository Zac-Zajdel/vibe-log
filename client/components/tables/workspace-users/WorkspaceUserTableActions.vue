<script setup lang="ts">
  import { Button } from '@/components/ui/button';
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu';
  import { useUser } from '@/hooks/authentication/useUser';
  import { MoreHorizontal, Trash } from 'lucide-vue-next';

  const props = defineProps<{
    workspaceUser: App.Data.Resource.WorkspaceUser.WorkspaceUserResource;
  }>();

  const user = useUser();
  const isDisabled = computed(
    () => user.value?.id === props.workspaceUser.user_id
  );

  const deleteUser = () => {
    console.log('Delete User');
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
