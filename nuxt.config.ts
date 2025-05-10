import tailwindcss from '@tailwindcss/vite';

export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },

  typescript: {
    typeCheck: true,
  },

  ssr: false,

  srcDir: 'client',

  modules: [
    '@nuxt/eslint',
    '@nuxt/image',
    'shadcn-nuxt',
    '@nuxtjs/color-mode',
    '@qirolab/nuxt-sanctum-authentication',
  ],

  colorMode: {
    storageKey: 'dark',
    classSuffix: '',
  },

  css: ['~/assets/css/main.css'],

  vite: {
    plugins: [tailwindcss()],
  },

  shadcn: {
    /**
     * Prefix for all the imported component
     */
    prefix: '',
    /**
     * Directory that the component lives in.
     * @default "./components/ui"
     */
    componentDir: './client/components/ui',
  },

  laravelSanctum: {
    apiUrl: process.env.NUXT_SANCTUM_API_URL,
    authMode: 'cookie',

    userResponseWrapperKey: 'data',

    sanctumEndpoints: {
      // Endpoint to request a new CSRF token from the server
      csrf: '/sanctum/csrf-cookie',

      // Endpoint used for user authentication
      login: '/api/login',

      // Endpoint used to log out users
      logout: '/api/logout',

      // Endpoint to retrieve the currently authenticated user's data
      user: '/api/user',
    },

    redirect: {
      // Preserve the originally requested route, redirecting users there after login
      enableIntendedRedirect: false,

      // Path to redirect users when a page requires authentication
      loginPath: '/login',

      // URL to redirect users to when guest-only access is required
      guestOnlyRedirect: '/',

      // URL to redirect to after a successful login
      redirectToAfterLogin: '/dashboard',

      // URL to redirect to after logging out
      redirectToAfterLogout: '/',
    },

    logLevel: 5,
  },
});
