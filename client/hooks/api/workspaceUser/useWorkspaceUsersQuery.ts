import { useQuery } from '@tanstack/vue-query';
import { toast } from 'vue-sonner';

export const useWorkspaceUsersQuery = ({
  key,
  page = 1,
  perPage = 5,
  search,
  enabled,
}: {
  key: string;
  page?: number;
  perPage?: number;
  search?: Ref<string>;
  enabled?: ComputedRef<boolean> | Ref<boolean>;
}) => {
  const { data, isLoading, isError } = useQuery({
    queryKey: [key, page, perPage, search],
    queryFn: async (): Promise<{
      workspaceUsers: App.Data.Resource.WorkspaceUser.WorkspaceUserResource[];
      total: number;
    }> => {
      const sanctumFetch = useSanctumClient();

      const requestData: App.Data.Request.WorkspaceUser.WorkspaceUserIndexData =
        {
          page: page ?? 1,
          search: search?.value?.length ? search.value : undefined,
          per_page: perPage ?? 10,
        };

      const { data } = await sanctumFetch(`workspace-users`, {
        params: requestData,
      });

      return {
        workspaceUsers: data.data,
        total: data.meta.total,
      };
    },
    enabled: enabled ?? true,
  });

  watch(isError, () =>
    toast.error('An error occurred while fetching workspace members.')
  );

  return {
    total: computed(() => data.value?.total || 0),
    workspaceUsers: computed(() => data.value?.workspaceUsers || []),
    isLoading,
    isError,
  };
};
