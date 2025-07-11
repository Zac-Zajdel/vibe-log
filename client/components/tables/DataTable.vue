<script setup lang="ts" generic="TData, TValue">
  import DataTablePagination from '@/components/tables/DataTablePagination.vue';
  import DataTableViewOptions from '@/components/tables/DataTableViewOptions.vue';
  import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
  } from '@/components/ui/table';
  import type {
    ColumnDef,
    ColumnFiltersState,
    SortingState,
    VisibilityState,
  } from '@tanstack/vue-table';
  import {
    FlexRender,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
  } from '@tanstack/vue-table';
  import { useDebounce } from '@vueuse/core';
  import { valueUpdater } from '~/lib/utils';

  const props = withDefaults(
    defineProps<{
      columns: ColumnDef<TData, TValue>[];
      data: TData[];
      hasSearch?: boolean;
      hasViewOptions?: boolean;
      hasPagination?: boolean;
    }>(),
    {
      hasSearch: true,
      hasViewOptions: true,
      hasPagination: true,
    }
  );

  const emit = defineEmits(['update:search']);

  const search = ref('');
  const debouncedSearch = useDebounce(search, 300);
  watch(debouncedSearch, (val) => emit('update:search', val));

  const sorting = ref<SortingState>([]);
  const columnFilters = ref<ColumnFiltersState>([]);
  const columnVisibility = ref<VisibilityState>({});

  const table = useVueTable({
    get data() {
      return props.data;
    },
    get columns() {
      return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    onSortingChange: (updaterOrValue) => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: (updaterOrValue) =>
      valueUpdater(updaterOrValue, columnFilters),
    getFilteredRowModel: getFilteredRowModel(),
    onColumnVisibilityChange: (updaterOrValue) =>
      valueUpdater(updaterOrValue, columnVisibility),
    state: {
      get sorting() {
        return sorting.value;
      },
      get columnFilters() {
        return columnFilters.value;
      },
      get columnVisibility() {
        return columnVisibility.value;
      },
    },
  });
</script>

<template>
  <div>
    <div class="flex items-center py-4">
      <Input
        v-if="hasSearch"
        v-model="search"
        class="h-8 max-w-[30%]"
        placeholder="Search..."
      />
      <DataTableViewOptions v-if="hasViewOptions" :table="table" />
    </div>
    <div class="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow
            v-for="headerGroup in table.getHeaderGroups()"
            :key="headerGroup.id"
          >
            <TableHead v-for="header in headerGroup.headers" :key="header.id">
              <FlexRender
                v-if="!header.isPlaceholder"
                :render="header.column.columnDef.header"
                :props="header.getContext()"
              />
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="table.getRowModel().rows?.length">
            <TableRow
              v-for="row in table.getRowModel().rows"
              :key="row.id"
              :data-state="row.getIsSelected() ? 'selected' : undefined"
            >
              <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                <FlexRender
                  :render="cell.column.columnDef.cell"
                  :props="cell.getContext()"
                />
              </TableCell>
            </TableRow>
          </template>
          <template v-else>
            <TableRow>
              <TableCell :colspan="columns.length" class="h-24 text-center">
                No results.
              </TableCell>
            </TableRow>
          </template>
        </TableBody>
      </Table>
    </div>
    <DataTablePagination v-if="hasPagination" :table="table" />
  </div>
</template>
