import DataTableColumnHeader from '@/components/tables/DataTableColumnHeader.vue';
import WorkspaceUserTableActions from '@/components/tables/workspace-users/WorkspaceUserTableActions.vue';
import type { ColumnDef } from '@tanstack/vue-table';
import { h } from 'vue';

export interface Payment {
  id: number;
  status: 'Pending' | 'Active';
  name: string;
  email: string;
}

export const workspaceUserColumns: ColumnDef<Payment>[] = [
  {
    accessorKey: 'name',
    header: ({ column }) =>
      h(DataTableColumnHeader, {
        column: column,
        title: 'Name',
      }),
  },
  {
    accessorKey: 'email',
    header: ({ column }) =>
      h(DataTableColumnHeader, {
        column: column,
        title: 'Email',
      }),
  },
  {
    accessorKey: 'status',
    header: ({ column }) =>
      h(DataTableColumnHeader, {
        column: column,
        title: 'Status',
      }),
  },
  {
    id: 'actions',
    enableHiding: false,
    cell: ({ row }) => {
      const payment = row.original;

      return h(
        'div',
        { class: 'text-right font-medium' },
        h(WorkspaceUserTableActions, {
          payment,
        })
      );
    },
  },
];
