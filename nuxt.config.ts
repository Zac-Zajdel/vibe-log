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

  runtimeConfig: {
    public: {
      apiUrl: process.env.NUXT_SANCTUM_API_URL,
    },
  },

  modules: [
    '@nuxt/eslint',
    '@nuxt/image',
    'shadcn-nuxt',
    '@nuxtjs/color-mode',
    'nuxt-auth-sanctum',
    'motion-v/nuxt',
    '@vueuse/nuxt',
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
    prefix: '',
    componentDir: './client/components/ui',
  },

  sanctum: {
    baseUrl: process.env.NUXT_SANCTUM_API_URL,
    globalMiddleware: {
      enabled: true,
    },
    endpoints: {
      csrf: '/api/v1/sanctum/csrf-cookie',
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
