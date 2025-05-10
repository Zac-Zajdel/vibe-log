<script setup lang="ts">
  definePageMeta({
    middleware: ['$guest'],
  });

  const { refreshUser } = useSanctum();

  const form = useSanctumForm('post', '/api/register', {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });

  async function registerUser() {
    if (form.processing) return;

    try {
      await form.submit();
      await refreshUser();
      return navigateTo('/dashboard');
    } catch (err) {
      console.error(err);
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
          <Input
            id="name"
            v-model="form.name"
            :class="{ 'border-red-600': form.invalid('name') }"
            @input="form.forgetError('name')"
          />
          <span v-if="form.invalid('name')" class="text-sm text-red-600">
            {{ form.errors.name }}
          </span>
        </div>
        <div class="mt-3 flex flex-col space-y-1">
          <Label for="email">Email</Label>
          <Input
            id="email"
            v-model="form.email"
            type="email"
            :class="{ 'border-red-600': form.invalid('email') }"
            @input="form.forgetError('email')"
          />
          <span v-if="form.invalid('email')" class="text-sm text-red-600">
            {{ form.errors.email }}
          </span>
        </div>
        <div class="mt-3 flex flex-col space-y-1">
          <Label for="password">Password</Label>
          <Input
            id="password"
            v-model="form.password"
            type="password"
            :class="{ 'border-red-600': form.invalid('password') }"
            @input="form.forgetError('password')"
          />
          <span v-if="form.invalid('password')" class="text-sm text-red-600">
            {{ form.errors.password }}
          </span>
        </div>
        <div class="mt-3 flex flex-col space-y-1">
          <Label for="password_confirmation">Password Confirmation</Label>
          <Input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            :class="{ 'border-red-600': form.invalid('password_confirmation') }"
            @input="form.forgetError('password_confirmation')"
          />
          <span
            v-if="form.invalid('password_confirmation')"
            class="text-sm text-red-600"
          >
            {{ form.errors.password_confirmation }}
          </span>
        </div>

        <Button
          type="submit"
          class="mt-5 w-full"
          :class="{
            'cursor-not-allowed opacity-50': form.processing,
          }"
        >
          Register
        </Button>
      </form>
    </div>
  </div>
</template>
