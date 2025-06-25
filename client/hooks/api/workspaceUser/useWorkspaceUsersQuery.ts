import { useUser } from '@/hooks/authentication/useUser';
import { useQuery } from '@tanstack/vue-query';

export const useWorkspaceUsersQuery = ({
  page = 1,
  perPage = 5,
  search,
}: {
  page?: number;
  perPage?: number;
  search?: Ref<string>;
}) => {
  const { data, isLoading } = useQuery({
    queryKey: ['workspace-users', page, perPage, search],
    queryFn: async (): Promise<{
      workspaceUsers: App.Data.Resource.WorkspaceUser.WorkspaceUserResource[];
      total: number;
    }> => {
      const user = useUser();
      const sanctumFetch = useSanctumClient();

      const requestData: App.Data.Request.WorkspaceUser.WorkspaceUserIndexData =
        {
          page: page ?? 1,
          search: search?.value,
          per_page: perPage ?? 10,
        };

      const { data } = await sanctumFetch(
        `workspaces/${user.value.active_workspace_id}/workspaceUser`,
        {
          params: requestData,
        }
      );

      return {
        workspaceUsers: data.data,
        total: data.meta.total,
      };
    },
  });

  return {
    total: computed(() => data.value?.total || 0),
    workspaceUsers: computed(() => data.value?.workspaceUsers || []),
    isLoading,
  };
};
