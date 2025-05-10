import tailwindcss from '@tailwindcss/vite';

export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },

  typescript: {
    typeCheck: true,
  },

  srcDir: 'client',

  modules: ['@nuxt/eslint', '@nuxt/image', 'shadcn-nuxt', '@nuxtjs/color-mode'],

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
});
