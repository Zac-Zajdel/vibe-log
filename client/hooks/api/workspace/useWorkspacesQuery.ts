import { useQuery } from '@tanstack/vue-query';

export const useWorkspacesQuery = ({
  page = 1,
  perPage = 5,
  search,
}: {
  page?: number;
  perPage?: number;
  search?: Ref<string>;
}) => {
  const { data, isLoading } = useQuery({
    queryKey: ['workspaces', page, perPage, search],
    queryFn: async (): Promise<{
      workspaces: App.Data.Resource.Workspace.WorkspaceResource[];
      total: number;
    }> => {
      const sanctumFetch = useSanctumClient();

      const { data } = await sanctumFetch('workspaces', {
        params: {
          page,
          search: search?.value || undefined,
          per_page: perPage,
        },
      });

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
