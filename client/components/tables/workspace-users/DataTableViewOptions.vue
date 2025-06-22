<script setup lang="ts">
  import type { Table } from '@tanstack/vue-table';
  import { Settings2 } from 'lucide-vue-next';
  import { computed } from 'vue';

  import { Button } from '@/components/ui/button';
  import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu';

  interface DataTableViewOptionsProps {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    table: Table<any>;
  }

  const props = defineProps<DataTableViewOptionsProps>();

  const columns = computed(() =>
    props.table
      .getAllColumns()
      .filter(
        (column) =>
          typeof column.accessorFn !== 'undefined' && column.getCanHide()
      )
  );
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="outline" size="sm" class="ml-auto hidden h-8 lg:flex">
        <Settings2 class="mr-2 h-4 w-4" />
        View
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end" class="w-[150px]">
      <DropdownMenuCheckboxItem
        v-for="column in columns"
        :key="column.id"
        class="capitalize"
        :modelValue="column.getIsVisible()"
        @update:model-value="(value) => column.toggleVisibility(!!value)"
      >
        {{ column.id }}
      </DropdownMenuCheckboxItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
