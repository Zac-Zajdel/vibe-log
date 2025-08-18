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
  <PageWrapper>
    <div class="container mx-auto">
      <div class="mb-8 flex items-center justify-between">
        <h1 class="text-2xl">Members</h1>
        <WorkspaceUserCreate />
      </div>
      <DataTable
        :columns="workspaceUserColumns"
        :data="workspaceUsers"
        @update:search="search = $event"
      />
    </div>
  </PageWrapper>
</template>
