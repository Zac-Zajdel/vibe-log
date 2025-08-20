<script setup lang="ts">
  import DataTable from '@/components/tables/DataTable.vue';
  import { workspaceUserColumns } from '@/components/tables/workspace-users/workspaceUserColumns';
  import WorkspaceUserCreate from '@/components/workspaceUsers/WorkspaceUserCreate.vue';
  import { useWorkspaceUsersQuery } from '@/hooks/api/workspaceUser/useWorkspaceUsersQuery';

  useHead({ title: 'Workspace Members' });

  const search = ref('');
  const { workspaceUsers } = useWorkspaceUsersQuery({
    key: 'workspace-users',
    search,
  });
</script>

<template>
  <PageWrapper class="mx-auto max-w-screen-xl">
    <div class="mb-8 flex items-center justify-between">
      <div>
        <h1 class="text-2xl">Members</h1>
        <p class="text-muted-foreground mt-1 text-sm">
          Update your workspace details and configurations.
        </p>
      </div>
      <WorkspaceUserCreate />
    </div>

    <DataTable
      :columns="workspaceUserColumns"
      :data="workspaceUsers"
      @update:search="search = $event"
    />
  </PageWrapper>
</template>
