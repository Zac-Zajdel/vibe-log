import { useUser } from '@/hooks/authentication/useUser';

export default defineNuxtRouteMiddleware(() => {
  const user = useUser();

  console.log(user.value);

  return;
});
