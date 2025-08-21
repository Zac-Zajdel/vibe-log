export default defineNuxtRouteMiddleware((to) => {
  if (['/', '/login', '/register'].includes(to?.path ?? '')) {
    return;
  }

  if (import.meta.client) {
    const user = localStorage.getItem('user');
    const userState = user ? JSON.parse(user) : null;

    if (!userState) {
      return;
    }

    // TODO - If not found, take them back to main organizations page.
    // TODO - Check to determine if the user belongs to the organization.
    // const organizationSlug = to.params.organization_slug;
    // if (userState?.organization_slugs.includes(organizationSlug)) {
    //   console.log('User from localStorage:', user);
    // }
  }

  return;
});
