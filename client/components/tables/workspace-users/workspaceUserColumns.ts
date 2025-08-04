import DataTableColumnHeader from '@/components/tables/DataTableColumnHeader.vue';
import WorkspaceUserTableActions from '@/components/tables/workspace-users/WorkspaceUserTableActions.vue';
import type { BadgeVariants } from '@/components/ui/badge';
import Badge from '@/components/ui/badge/Badge.vue';
import type { ColumnDef } from '@tanstack/vue-table';
import dayjs from 'dayjs';
import { h } from 'vue';

export const workspaceUserColumns: ColumnDef<App.Data.Resource.WorkspaceUser.WorkspaceUserResource>[] =
  [
    {
      id: 'Status',
      accessorKey: 'status',
      enableSorting: false,
      enableHiding: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Status',
        }),
      cell: ({ row }) => {
        const status =
          row.original.status.charAt(0).toUpperCase() +
          row.original.status.slice(1);

        let colorVariant: BadgeVariants['variant'] = 'active';
        switch (status) {
          case 'Invited':
            colorVariant = 'warning';
            break;
          case 'Active':
            colorVariant = 'active';
            break;
          case 'Disabled':
            colorVariant = 'destructive';
            break;
        }

        return h(Badge, { variant: colorVariant }, { default: () => status });
      },
    },
    {
      id: 'Username',
      accessorKey: 'username',
      enableSorting: false,
      enableHiding: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Name',
        }),
      cell: ({ row }) => {
        const username = row.original.username;

        if (!username) {
          return h('div', { class: 'text-muted-foreground' }, '---');
        }

        const role =
          row.original.role.charAt(0).toUpperCase() +
          row.original.role.slice(1);

        return h('div', { class: 'flex items-center gap-4' }, [
          h(Badge, {}, { default: () => role }),
          h('span', {}, username),
        ]);
      },
    },
    {
      id: 'Email',
      accessorKey: 'user.email',
      enableSorting: false,
      enableHiding: false,
      header: ({ column }) =>
        h(DataTableColumnHeader, {
          column: column,
          title: 'Email',
        }),
      cell: ({ row }) => {
        const email = row.original.user?.email;

        if (!email) {
          return h('div', { class: 'text-muted-foreground' }, '---');
        }

        return h('div', {}, email);
      },
    },
    {
      id: 'Joined',
      accessorKey: 'joined_at',
      enableSorting: false,
      enableHiding: false,
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
