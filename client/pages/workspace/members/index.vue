<script setup lang="ts">
  import DataTable from '@/components/tables/DataTable.vue';
  import {
    workspaceUserColumns,
    type Payment,
  } from '@/components/tables/workspace-users/workspaceUserColumns';
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { Box, Users } from 'lucide-vue-next';

  useHead({ title: 'Workspace Members' });

  const breadcrumbs: Breadcrumbs = [
    { title: 'Workspace', icon: Box },
    { title: 'Members', icon: Users },
  ];

  const data = ref<Payment[]>([]);

  async function getData(): Promise<Payment[]> {
    return [
      {
        id: 1,
        name: 'johnny',
        email: 'johnny@example.com',
        status: 'Pending',
      },
      {
        id: 2,
        name: 'arnold',
        email: 'arnold@me.com',
        status: 'Active',
      },
      {
        id: 3,
        name: 'billy',
        email: 'billy@me.com',
        status: 'Active',
      },
    ];
  }

  onMounted(async () => {
    data.value = await getData();
  });
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="container mx-auto py-10">
      <DataTable :columns="workspaceUserColumns" :data="data" />
    </div>
  </PageWrapper>
</template>
