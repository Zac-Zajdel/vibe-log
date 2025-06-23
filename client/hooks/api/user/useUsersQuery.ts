import { useQuery } from '@tanstack/vue-query';

export const useUsersQuery = ({
  page = 1,
  perPage = 5,
  search,
}: {
  page?: number;
  perPage?: number;
  search?: Ref<string>;
}) => {
  const { data, isLoading } = useQuery({
    queryKey: ['users', page, perPage, search],
    queryFn: async (): Promise<{
      users: App.Data.Resource.User.UserResource[];
      total: number;
    }> => {
      const sanctumFetch = useSanctumClient();

      const requestData: App.Data.Request.User.UserIndexData = {
        page: page ?? 1,
        search: search?.value,
        per_page: perPage ?? 10,
      };

      const { data } = await sanctumFetch('users', {
        params: requestData,
      });

      return {
        users: data.data,
        total: data.meta.total,
      };
    },
  });

  return {
    total: computed(() => data.value?.total || 0),
    users: computed(() => data.value?.users || []),
    isLoading,
  };
};
