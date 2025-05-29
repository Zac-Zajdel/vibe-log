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
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    onError: (error: any) => {
      toast.error(error?.data?.message);
    },
  });
};
