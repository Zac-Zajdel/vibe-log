<script setup lang="ts">
  definePageMeta({
    middleware: ['$guest'],
  });

  const form = ref({
    email: '',
    password: '',
  });

  const { login } = useSanctum();

  const submitForm = async () => {
    const result = await login(form.value);
    console.log(result);
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
