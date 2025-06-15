import type { ValidationError } from '@/types/errors';
import { useMutation } from '@tanstack/vue-query';
import { toast } from 'vue-sonner';

export const useStoreWorkspaceMutation = () => {
  return useMutation({
    mutationFn: async (
      payload: App.Data.Request.Workspace.WorkspaceStoreData
    ): Promise<{
      workspace: App.Data.Resource.Workspace.WorkspaceResource;
      message: string;
    }> => {
      const sanctumFetch = useSanctumClient();

      const { data, message } = await sanctumFetch(`workspaces`, {
        method: 'POST',
        body: JSON.stringify(payload),
      });

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
