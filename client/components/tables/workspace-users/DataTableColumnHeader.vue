<script setup lang="ts">
  import type { Column } from '@tanstack/vue-table';
  import { ArrowDown, ArrowUp, ChevronsUpDown } from 'lucide-vue-next';

  import { Button } from '@/components/ui/button';
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu';
  import { cn } from '@/lib/utils';

  interface DataTableColumnHeaderProps {
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    column: Column<any, any>;
    title: string;
  }

  defineProps<DataTableColumnHeaderProps>();
</script>

<script lang="ts">
  export default {
    inheritAttrs: false,
  };
</script>

<template>
  <div
    v-if="column.getCanSort()"
    :class="cn('flex items-center space-x-2', $attrs.class ?? '')"
  >
    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <Button
          variant="ghost"
          size="sm"
          class="data-[state=open]:bg-accent -ml-3 h-8"
        >
          <span>{{ title }}</span>
          <ArrowDown
            v-if="column.getIsSorted() === 'desc'"
            class="ml-2 h-4 w-4"
          />
          <ArrowUp
            v-else-if="column.getIsSorted() === 'asc'"
            class="ml-2 h-4 w-4"
          />
          <ChevronsUpDown v-else class="ml-2 h-4 w-4" />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="start">
        <DropdownMenuItem @click="column.toggleSorting(false)">
          <ArrowUp class="text-muted-foreground/70 mr-2 h-3.5 w-3.5" />
          Asc
        </DropdownMenuItem>
        <DropdownMenuItem @click="column.toggleSorting(true)">
          <ArrowDown class="text-muted-foreground/70 mr-2 h-3.5 w-3.5" />
          Desc
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>
  </div>

  <div v-else :class="$attrs.class">
    {{ title }}
  </div>
</template>
