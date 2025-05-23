<script setup lang="ts">
  definePageMeta({
    middleware: ['sanctum:guest'],
  });

  const { login } = useSanctumAuth();

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
  <div class="flex min-h-screen items-center justify-center">
    <Card class="w-[350px]">
      <CardHeader>
        <CardTitle>Vibe Brief</CardTitle>
      </CardHeader>
      <form @submit.prevent="submitForm">
        <CardContent>
          <div class="grid w-full items-center gap-4">
            <div class="flex flex-col space-y-1.5">
              <Label for="email">Email</Label>
              <Input id="email" v-model="form.email" type="email" />
            </div>
            <div class="flex flex-col space-y-1.5">
              <Label for="password">Password</Label>
              <Input id="password" v-model="form.password" type="password" />
            </div>
          </div>
        </CardContent>
        <CardFooter class="flex justify-end px-6 pt-6">
          <Button type="submit">Login</Button>
        </CardFooter>
      </form>
    </Card>
  </div>
</template>
