<script setup lang="ts">
  import { Button } from '@/components/ui/button';
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu';
  import { MoreHorizontal, Pause, ShieldPlus, Trash } from 'lucide-vue-next';

  defineProps<{
    workspaceUser: App.Data.Resource.WorkspaceUser.WorkspaceUserResource;
  }>();

  const activateUser = () => {
    console.log('Activate User');
  };

  const disableUser = () => {
    console.log('Disable User');
  };

  const deleteUser = () => {
    console.log('Delete User');
  };
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="size-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="size-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuItem
        v-if="workspaceUser.joined_at && !workspaceUser.is_active"
        @click="activateUser"
      >
        <ShieldPlus />
        Activate
      </DropdownMenuItem>
      <DropdownMenuItem v-if="workspaceUser.joined_at" @click="disableUser">
        <Pause />
        Disable
      </DropdownMenuItem>
      <DropdownMenuItem v-if="!workspaceUser.joined_at" @click="deleteUser">
        <Trash />
        Delete
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
