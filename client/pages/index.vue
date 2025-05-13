<script setup lang="ts">
  definePageMeta({
    middleware: ['$guest'],
  });
</script>

<template>
  <div class="flex min-h-screen flex-col items-center justify-center">
    <div class="space-y-6 text-center">
      <h1 class="text-4xl font-bold">Welcome to Win The Take</h1>
      <p class="text-lg text-gray-600 dark:text-gray-300">
        Post it. Prove it. Win the take.
      </p>

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
