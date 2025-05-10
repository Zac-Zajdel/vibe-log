<script setup lang="ts">
  definePageMeta({
    middleware: ['$guest'],
  });
</script>

<template>
  <div class="mt-10 flex flex-col items-center justify-center space-y-4">
    <NuxtLink to="/dashboard">Dashboard</NuxtLink>
    <NuxtLink to="/login">Login</NuxtLink>
    <NuxtLink to="/register">Register</NuxtLink>
  </div>
</template>
