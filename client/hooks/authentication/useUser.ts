import { useStorage } from '@vueuse/core';

export const useUser = (): ComputedRef<App.Data.Resource.User.UserResource> => {
  const user = useSanctumUser<{ data: App.Data.Resource.User.UserResource }>();

  const userState = useStorage('user', user.value?.data);
  console.log('userState', userState.value);

  return computed(
    () => user.value?.data as App.Data.Resource.User.UserResource
  );
};
