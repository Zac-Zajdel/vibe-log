import type { ValidationError } from '@/types/errors';
import { useMutation } from '@tanstack/vue-query';
import { toast } from 'vue-sonner';

export const useDestroyWorkspaceUserMutation = () => {
  return useMutation({
    mutationFn: async (
      workspaceUserId: number
    ): Promise<{
      message: string;
    }> => {
      const sanctumFetch = useSanctumClient();

      const { message } = await sanctumFetch(
        `workspace-users/${workspaceUserId}`,
        {
          method: 'DELETE',
        }
      );

      return { message };
    },
    onError: (error: ValidationError) => {
      toast.error(error?.data?.message);
    },
  });
};
