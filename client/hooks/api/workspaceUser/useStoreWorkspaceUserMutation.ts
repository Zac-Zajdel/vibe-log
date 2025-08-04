import type { ValidationError } from '@/types/errors';
import { useMutation } from '@tanstack/vue-query';
import { toast } from 'vue-sonner';

export const useStoreWorkspaceUserMutation = () => {
  return useMutation({
    mutationFn: async (
      payload: App.Data.Request.WorkspaceUser.WorkspaceUserStoreData
    ): Promise<{
      workspaceUser: App.Data.Resource.WorkspaceUser.WorkspaceUserResource;
      message: string;
    }> => {
      const sanctumFetch = useSanctumClient();

      const { data, message } = await sanctumFetch(`workspace-users`, {
        method: 'POST',
        body: JSON.stringify(payload),
      });

      return {
        message,
        workspaceUser: data,
      };
    },
    onError: (error: ValidationError) => {
      toast.error(error?.data?.message);
    },
  });
};
