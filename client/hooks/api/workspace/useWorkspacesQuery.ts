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

      const requestData: App.Data.Request.Workspace.WorkspaceIndexData = {
        page: page ?? 1,
        search: search?.value,
        per_page: perPage ?? 10,
      };

      const { data } = await sanctumFetch('workspaces', {
        params: requestData,
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
