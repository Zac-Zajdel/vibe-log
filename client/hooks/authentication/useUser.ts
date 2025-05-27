export const useUser = () => {
  return useSanctumUser<{ data: App.Data.Resource.User.UserResource }>();
};
