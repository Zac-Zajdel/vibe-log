<script setup lang="ts">
  import DataTable from '@/components/tables/DataTable.vue';
  import { workspaceUserColumns } from '@/components/tables/workspace-users/workspaceUserColumns';
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
    <div class="container mx-auto py-10">
      <DataTable
        :columns="workspaceUserColumns"
        :data="workspaceUsers"
        @update:search="search = $event"
      />
    </div>
  </PageWrapper>
</template>
