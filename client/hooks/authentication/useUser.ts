export const useUser = (): ComputedRef<App.Data.Resource.User.UserResource> => {
  const user = useSanctumUser<{ data: App.Data.Resource.User.UserResource }>();
  return computed(
    () => user.value?.data as App.Data.Resource.User.UserResource
  );
};
