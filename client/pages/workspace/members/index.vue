<script setup lang="ts">
  import DataTable from '@/components/tables/DataTable.vue';
  import { workspaceUserColumns } from '@/components/tables/workspace-users/workspaceUserColumns';
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { useDebounce } from '@vueuse/core';
  import { Box, Users } from 'lucide-vue-next';
  import { useUsersQuery } from '~/hooks/api/user/useUsersQuery';

  useHead({ title: 'Workspace Members' });

  const breadcrumbs: Breadcrumbs = [
    { title: 'Workspace', icon: Box },
    { title: 'Members', icon: Users },
  ];

  interface Payment {
    id: number;
    status: 'Pending' | 'Active';
    name: string;
    email: string;
  }

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

  const search = ref('');
  const debouncedSearch = useDebounce(search, 300);
  const { users } = useUsersQuery({
    search: debouncedSearch,
  });

  onMounted(async () => {
    data.value = await getData();
  });
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="container mx-auto py-10">
      <DataTable :columns="workspaceUserColumns" :data="users" />
    </div>
  </PageWrapper>
</template>
