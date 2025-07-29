import DataTableColumnHeader from '@/components/tables/DataTableColumnHeader.vue';
import WorkspaceUserTableActions from '@/components/tables/workspace-users/WorkspaceUserTableActions.vue';
import type { ColumnDef } from '@tanstack/vue-table';
import dayjs from 'dayjs';
import { h } from 'vue';

export const workspaceUserColumns: ColumnDef<App.Data.Resource.WorkspaceUser.WorkspaceUserResource>[] =
  [
    // TODO - Loading state of the table...
    {
      id: 'Status',
      accessorKey: 'status',
      enableSorting: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Status',
        }),
    },
    {
      id: 'Username',
      accessorKey: 'username',
      enableSorting: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Username',
        }),
    },
    // TODo - Custom to be '---' if they leave.
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
      id: 'Role',
      accessorKey: 'role',
      enableSorting: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Role',
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
