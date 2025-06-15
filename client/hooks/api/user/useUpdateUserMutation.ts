import type { ValidationError } from '@/types/errors';
import { useMutation } from '@tanstack/vue-query';
import { toast } from 'vue-sonner';

export const useUpdateUserMutation = () => {
  return useMutation({
    mutationFn: async (
      user: App.Data.Resource.User.UserResource
    ): Promise<{
      user: App.Data.Resource.User.UserResource;
      message: string;
    }> => {
      const sanctumFetch = useSanctumClient();

      const { data, message } = await sanctumFetch(`users/${user.id}`, {
        method: 'PUT',
        body: JSON.stringify({
          name: user.name,
          email: user.email,
          active_workspace_id: user.active_workspace_id,
        }),
      });

      return {
        message,
        user: data,
      };
    },
    onError: (error: ValidationError) => {
      toast.error(error?.data?.message);
    },
  });
};
