export const useUser = (): App.Data.Resource.User.UserResource => {
  const user = useSanctumUser<{ data: App.Data.Resource.User.UserResource }>();
  return user.value?.data as App.Data.Resource.User.UserResource;
};
