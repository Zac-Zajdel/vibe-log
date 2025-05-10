<script setup lang="ts">
  definePageMeta({
    middleware: ['$guest'],
  });

  const { login } = useSanctum();

  const form = ref({
    email: '',
    password: '',
  });

  const submitForm = async () => {
    try {
      await login(form.value);
    } catch (err) {
      console.log(err);
    }
  };
</script>

<template>
  <div class="flex min-h-screen flex-col items-center justify-center">
    <div class="w-full max-w-md space-y-3 rounded-xl p-8 shadow-lg">
      <h1 class="text-center text-2xl font-bold">Login</h1>
      <form class="space-y-3" @submit.prevent="submitForm">
        <div class="flex flex-col space-y-1">
          <Label for="email">Email</Label>
          <Input id="email" v-model="form.email" type="email" />
        </div>
        <div class="flex flex-col space-y-2">
          <Label for="password">Password</Label>
          <Input id="password" v-model="form.password" type="password" />
        </div>

        <Button type="submit" class="mt-5 w-full">Login</Button>
      </form>
    </div>
  </div>
</template>
