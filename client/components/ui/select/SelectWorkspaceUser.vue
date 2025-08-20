<script setup lang="ts">
  import { useWorkspaceUsersQuery } from '@/hooks/api/workspaceUser/useWorkspaceUsersQuery';

  const props = defineProps<{
    owner: App.Data.Resource.User.UserResource | undefined;
  }>();

  const emit = defineEmits<{
    (
      e: 'select',
      user: App.Data.Resource.WorkspaceUser.WorkspaceUserResource
    ): void;
  }>();

  const enableWorkspaceUserQuery = ref(false);
  const selectedWorkspaceUserId = ref<number | null>(null);

  const { workspaceUsers } = useWorkspaceUsersQuery({
    key: 'select-workspace-owner',
    enabled: enableWorkspaceUserQuery,
  });

  const workspaceUsersList = computed(() => {
    if (workspaceUsers.value.length > 0) return workspaceUsers.value;

    if (props.owner) {
      return [
        {
          id: -1,
          user_id: props.owner.id,
          username: props.owner.name,
          user: props.owner,
        } as unknown as App.Data.Resource.WorkspaceUser.WorkspaceUserResource,
      ];
    }

    return [];
  });

  // Set initial selection to owner if present.
  watch(
    () => props.owner,
    (owner) => {
      if (owner) {
        const ownerWorkspaceUser = workspaceUsers.value.find(
          (workspaceUser) => workspaceUser.user_id === owner.id
        );

        if (ownerWorkspaceUser) {
          selectedWorkspaceUserId.value = ownerWorkspaceUser.id;
        } else {
          selectedWorkspaceUserId.value = -1;
        }
      }
    },
    { immediate: true }
  );

  // Emit the selected workspace user when changed.
  watch(selectedWorkspaceUserId, (id) => {
    if (id == null) return;

    const user = workspaceUsersList.value.find(
      (workspaceUser) => workspaceUser.id === id
    );
    if (user) emit('select', user);
  });
</script>

<template>
  <Select
    v-model="selectedWorkspaceUserId"
    class="w-full"
    @update:open="() => (enableWorkspaceUserQuery = true)"
  >
    <SelectTrigger class="w-full">
      <SelectValue placeholder="Select a user" />
    </SelectTrigger>
    <SelectContent>
      <SelectItem
        v-for="user in workspaceUsersList"
        :key="user.id"
        :value="user.id"
      >
        {{ user.username || user.user?.email || 'Unknown User' }}
      </SelectItem>
    </SelectContent>
  </Select>
</template>
