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
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    onError: (error: any) => {
      toast.error(error?.data?.message);
    },
  });
};
