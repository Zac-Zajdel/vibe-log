import { useMutation, useQueryClient } from '@tanstack/vue-query';
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

      const { data } = await sanctumFetch(`users/${user.id}`, {
        method: 'PUT',
        body: JSON.stringify({
          name: user.name,
          email: user.email,
          active_workspace_id: user.active_workspace_id,
        }),
      });

      return {
        message: data.message,
        user: data.user,
      };
    },
    onSuccess: async ({ message }: { message: string }) => {
      toast.success(message);

      // Re-queries the user to get the updated active workspace.
      const { refreshIdentity } = useSanctumAuth();
      refreshIdentity();

      // Updates the sidebar options within the dropdown menu.
      const queryClient = useQueryClient();
      queryClient.invalidateQueries({
        queryKey: ['workspaces'],
      });
    },
    onError: (error) => toast.error(error.message),
  });
};
