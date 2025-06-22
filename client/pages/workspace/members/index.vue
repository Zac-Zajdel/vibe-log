<script setup lang="ts">
  import {
    columns,
    type Payment,
  } from '@/components/tables/workspace-users/columns';
  import DataTable from '@/components/tables/workspace-users/DataTable.vue';
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { Box, Users } from 'lucide-vue-next';

  useHead({ title: 'Workspace Members' });

  const breadcrumbs: Breadcrumbs = [
    { title: 'Workspace', icon: Box },
    { title: 'Members', icon: Users },
  ];

  const data = ref<Payment[]>([]);

  async function getData(): Promise<Payment[]> {
    // Fetch data from your API here.
    return [
      {
        id: '728ed52f',
        amount: 100,
        status: 'pending',
        email: 'm@example.com',
      },
      {
        id: '728e34d52f',
        amount: 8230,
        status: 'success',
        email: 'apple.com',
      },
      // ...
    ];
  }

  onMounted(async () => {
    data.value = await getData();
  });
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="container mx-auto py-10">
      <DataTable :columns="columns" :data="data" />
    </div>
  </PageWrapper>
</template>
