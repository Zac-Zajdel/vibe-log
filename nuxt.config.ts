import tailwindcss from '@tailwindcss/vite';

export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: false },

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
    'nuxt-auth-sanctum',
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

  sanctum: {
    baseUrl: process.env.NUXT_SANCTUM_API_URL,

    userStateKey: 'data',

    endpoints: {
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
      // Path to redirect users when a page requires authentication
      onLogin: '/dashboard',

      // URL to redirect users to when guest-only access is required
      onGuestOnly: '/',

      // URL to redirect to after logging out
      onLogout: '/',
    },

    logLevel: 5,
  },
});
