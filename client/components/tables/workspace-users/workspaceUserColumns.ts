import DataTableColumnHeader from '@/components/tables/DataTableColumnHeader.vue';
import WorkspaceUserTableActions from '@/components/tables/workspace-users/WorkspaceUserTableActions.vue';
import { Badge } from '@/components/ui/badge';
import type { ColumnDef } from '@tanstack/vue-table';
import dayjs from 'dayjs';
import { h } from 'vue';

export const workspaceUserColumns: ColumnDef<App.Data.Resource.WorkspaceUser.WorkspaceUserResource>[] =
  [
    {
      id: 'Status',
      accessorKey: 'status',
      enableSorting: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Status',
        }),
      cell: ({ row }) => {
        const joinedAt = row.original.joined_at;

        return h('div', {}, [
          h(
            Badge,
            {
              variant: joinedAt ? 'secondary' : 'outline',
              class: joinedAt
                ? 'bg-green-500/10 text-green-700 border-green-500/20'
                : 'bg-yellow-500/10 text-yellow-700 border-yellow-500/20',
            },
            () => (joinedAt ? 'Active' : 'Pending')
          ),
        ]);
      },
    },
    {
      id: 'Name',
      accessorKey: 'user.name',
      enableSorting: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Name',
        }),
    },
    {
      id: 'Email',
      accessorKey: 'user.email',
      enableSorting: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Email',
        }),
    },
    {
      id: 'Joined',
      accessorKey: 'joined_at',
      enableSorting: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Joined',
        }),
      cell: ({ row }) => {
        const joinedAt = row.original.joined_at;

        if (!joinedAt) {
          return h('div', { class: 'text-muted-foreground' }, '---');
        }

        return h('div', {}, dayjs(joinedAt).format('MMM D, YYYY'));
      },
    },
    {
      id: 'actions',
      enableHiding: false,
      cell: ({ row }) => {
        const workspaceUser = row.original;

        return h(
          'div',
          { class: 'text-right font-medium' },
          h(WorkspaceUserTableActions, {
            workspaceUser,
          })
        );
      },
    },
  ];
