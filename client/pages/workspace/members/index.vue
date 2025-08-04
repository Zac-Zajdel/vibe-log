<script setup lang="ts">
  import DataTable from '@/components/tables/DataTable.vue';
  import { workspaceUserColumns } from '@/components/tables/workspace-users/workspaceUserColumns';
  import WorkspaceUserCreate from '@/components/workspaceUsers/WorkspaceUserCreate.vue';
  import { useWorkspaceUsersQuery } from '@/hooks/api/workspaceUser/useWorkspaceUsersQuery';
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { Box, Users } from 'lucide-vue-next';

  useHead({ title: 'Workspace Members' });

  const breadcrumbs: Breadcrumbs = [
    { title: 'Workspace', icon: Box },
    { title: 'Members', icon: Users },
  ];

  const search = ref('');
  const { workspaceUsers } = useWorkspaceUsersQuery({ search });
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
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
