import { useStorage } from '@vueuse/core';

export const useUser = (): ComputedRef<App.Data.Resource.User.UserResource> => {
  const user = useSanctumUser<{ data: App.Data.Resource.User.UserResource }>();

  // TODO - Fix this...
  useStorage('user', user.value?.data);

  return computed(
    () => user.value?.data as App.Data.Resource.User.UserResource
  );
};
