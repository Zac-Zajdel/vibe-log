<script setup lang="ts">
  import { toast } from 'vue-sonner';

  useHead({ titleTemplate: 'Register | Vibe Log' });

  definePageMeta({
    sanctum: {
      guestOnly: true,
    },
  });

  const { refreshIdentity } = useSanctumAuth();

  const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });

  async function registerUser() {
    try {
      // First get the CSRF cookie
      await $fetch('http://localhost:8000/sanctum/csrf-cookie', {
        credentials: 'include',
      });

      // Get the CSRF token from cookie and decode it
      const token = decodeURIComponent(
        document.cookie
          .split('; ')
          .find((row) => row.startsWith('XSRF-TOKEN='))
          ?.split('=')[1] ?? ''
      );

      // Now make the registration request with the CSRF token
      await $fetch('http://localhost:8000/api/v1/register', {
        method: 'POST',
        body: JSON.stringify(form.value),
        headers: {
          'Content-Type': 'application/json',
          'X-XSRF-TOKEN': token,
        },
        credentials: 'include',
      });

      await refreshIdentity();
      return navigateTo('/home');
      // eslint-disable-next-line @typescript-eslint/no-explicit-any
    } catch (err: any) {
      toast.error(err.data.message);
    }
  }
</script>

<template>
  <div class="flex min-h-screen flex-col items-center justify-center">
    <div class="w-full max-w-md space-y-3 rounded-xl p-8 shadow-lg">
      <h1 class="text-center text-2xl font-bold">Register</h1>
      <form @submit.prevent="registerUser">
        <div class="flex flex-col space-y-1">
          <Label for="name">Name</Label>
          <Input id="name" v-model="form.name" />
        </div>
        <div class="mt-3 flex flex-col space-y-1">
          <Label for="email">Email</Label>
          <Input id="email" v-model="form.email" type="email" />
        </div>
        <div class="mt-3 flex flex-col space-y-1">
          <Label for="password">Password</Label>
          <Input id="password" v-model="form.password" type="password" />
        </div>
        <div class="mt-3 flex flex-col space-y-1">
          <Label for="password_confirmation">Password Confirmation</Label>
          <Input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
          />
        </div>

        <Button type="submit" class="mt-5 w-full">Register</Button>
      </form>
    </div>
  </div>
</template>
