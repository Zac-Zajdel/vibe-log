import { useUser } from '@/hooks/authentication/useUser';
import type { ValidationError } from '@/types/errors';
import { useMutation } from '@tanstack/vue-query';
import { toast } from 'vue-sonner';

export const useUpdateWorkspaceMutation = () => {
  return useMutation({
    mutationFn: async (
      payload: App.Data.Request.Workspace.WorkspaceUpdateData
    ): Promise<{
      workspace: App.Data.Resource.Workspace.WorkspaceResource;
      message: string;
    }> => {
      const user = useUser();
      const sanctumFetch = useSanctumClient();

      const { data, message } = await sanctumFetch(
        `workspaces/${user.value.active_workspace_id}`,
        {
          method: 'PUT',
          body: JSON.stringify(payload),
        }
      );

      return {
        message,
        workspace: data,
      };
    },
    onError: (error: ValidationError) => {
      toast.error(error?.data?.message);
    },
  });
};
