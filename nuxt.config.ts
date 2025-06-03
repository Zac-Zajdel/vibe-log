import tailwindcss from '@tailwindcss/vite';

export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: false },

  app: {
    head: {
      titleTemplate: '%s | Vibe Log',
      htmlAttrs: {
        lang: 'en',
      },
    },
  },

  typescript: {
    typeCheck: true,
  },

  ssr: true,

  srcDir: 'client',

  modules: [
    '@nuxt/eslint',
    '@nuxt/image',
    'shadcn-nuxt',
    '@nuxtjs/color-mode',
    'nuxt-auth-sanctum',
    'motion-v/nuxt',
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
    globalMiddleware: {
      enabled: true,
    },
    endpoints: {
      csrf: '/sanctum/csrf-cookie',
      login: 'login',
      logout: 'logout',
      user: 'user',
    },
    redirect: {
      onLogout: '/',
      onAuthOnly: '/',
      onGuestOnly: '/home',
    },
    logLevel: 3,
  },
});
