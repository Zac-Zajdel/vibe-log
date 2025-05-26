import { useQuery } from '@tanstack/vue-query';

export const useWorkspacesQuery = (page: number, itemsPerPage: number) => {
  const { data, isLoading } = useQuery({
    queryKey: ['workspaces', page, itemsPerPage],
    queryFn: async (): Promise<{
      workspaces: App.Data.Resource.Workspace.WorkspaceResource[];
      total: number;
    }> => {
      const sanctumFetch = useSanctumClient();

      const { data } = await sanctumFetch('/api/v1/workspaces');

      return {
        workspaces: data.data,
        total: data.meta.total,
      };
    },
  });

  return {
    total: computed(() => data.value?.total || 0),
    workspaces: computed(() => data.value?.workspaces || []),
    isLoading,
  };
};
