<script setup lang="ts">
  definePageMeta({
    middleware: ['sanctum:guest'],
  });
</script>

<template>
  <div>
    <LandingNavBar />
    <div class="mt-24 space-y-6 text-center">
      <h1 class="text-4xl font-bold">Welcome to Vibe Log</h1>
      <p class="text-lg text-gray-600 dark:text-gray-300">Good Vibes Only.</p>

      <div class="space-y-4">
        <div class="flex justify-center gap-4">
          <Button>
            <NuxtLink to="/login">Login</NuxtLink>
          </Button>

          <Button>
            <NuxtLink to="/register">Register</NuxtLink>
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>
