import { useUser } from '@/hooks/authentication/useUser';
import { useQuery } from '@tanstack/vue-query';
import { toast } from 'vue-sonner';

export const useWorkspaceQuery = () => {
  const { data, isLoading, isError } = useQuery({
    queryKey: ['workspace'],
    queryFn: async (): Promise<{
      workspace?: App.Data.Resource.Workspace.WorkspaceResource;
    }> => {
      const user = useUser();
      const sanctumFetch = useSanctumClient();

      const { data } = await sanctumFetch(
        `workspaces/${user.value.active_workspace_id}`
      );

      return {
        workspace: data,
      };
    },
  });

  watch(isError, () =>
    toast.error('An error occurred while fetching this workspace.')
  );

  return {
    workspace: computed(() => data.value?.workspace),
    isLoading,
    isError,
  };
};
