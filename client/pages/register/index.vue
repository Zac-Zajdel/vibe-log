<script setup lang="ts">
  import { useForm } from '@tanstack/vue-form';
  import { toast } from 'vue-sonner';

  useHead({ titleTemplate: 'Register | Vibe Log' });

  definePageMeta({
    sanctum: {
      guestOnly: true,
    },
  });

  const config = useRuntimeConfig();
  const { refreshIdentity } = useSanctumAuth();

  const form = useForm({
    defaultValues: {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
    },
    onSubmit: async ({ value }) => {
      try {
        // First get the CSRF cookie
        await $fetch(`${config.public.apiUrl}sanctum/csrf-cookie`, {
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
        await $fetch(`${config.public.apiUrl}register`, {
          method: 'POST',
          body: JSON.stringify(value),
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
    },
  });
</script>

<template>
  <div class="flex min-h-screen items-center justify-center">
    <Card class="w-[400px]">
      <CardHeader class="mb-3 flex justify-center text-xl">
        <CardTitle>Create An Account</CardTitle>
      </CardHeader>
      <CardContent>
        <form @submit.prevent.stop="form.handleSubmit">
          <div class="space-y-3">
            <form.Field name="name">
              <template #default="{ field }">
                <Label :for="field.name">Name</Label>
                <Input
                  :id="field.name"
                  v-model="field.state.value"
                  :name="field.name"
                  @blur="field.handleBlur"
                  @input="
                    (e: Event) =>
                      field.handleChange((e.target as HTMLInputElement).value)
                  "
                />
              </template>
            </form.Field>
            <form.Field name="email">
              <template #default="{ field }">
                <Label :for="field.name">Email</Label>
                <Input
                  :id="field.name"
                  v-model="field.state.value"
                  :name="field.name"
                  @blur="field.handleBlur"
                  @input="
                    (e: Event) =>
                      field.handleChange((e.target as HTMLInputElement).value)
                  "
                />
              </template>
            </form.Field>
            <form.Field name="password">
              <template #default="{ field }">
                <Label :for="field.name">Password</Label>
                <Input
                  :id="field.name"
                  v-model="field.state.value"
                  :name="field.name"
                  type="password"
                  autocomplete="current-password"
                  @blur="field.handleBlur"
                  @input="
                    (e: Event) =>
                      field.handleChange((e.target as HTMLInputElement).value)
                  "
                />
              </template>
            </form.Field>
            <form.Field name="password_confirmation">
              <template #default="{ field }">
                <Label :for="field.name">Password Confirmation</Label>
                <Input
                  :id="field.name"
                  v-model="field.state.value"
                  :name="field.name"
                  type="password"
                  autocomplete="current-password"
                  @blur="field.handleBlur"
                  @input="
                    (e: Event) =>
                      field.handleChange((e.target as HTMLInputElement).value)
                  "
                />
              </template>
            </form.Field>
          </div>
          <Button type="submit" class="mt-10 w-full">Register</Button>
        </form>
      </CardContent>
      <CardFooter class="my-3 flex items-center justify-center px-6">
        <div class="space-y-5">
          <p class="text-center text-sm">
            Have an account?
            <NuxtLink to="/login" class="text-muted-foreground ml-1 underline">
              Login
            </NuxtLink>
          </p>
        </div>
      </CardFooter>
    </Card>
  </div>
</template>
