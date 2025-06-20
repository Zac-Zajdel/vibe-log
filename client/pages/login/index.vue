<script setup lang="ts">
  import { useForm } from '@tanstack/vue-form';
  import { Mail } from 'lucide-vue-next';
  import { toast } from 'vue-sonner';
  import { z } from 'zod/v4';

  useHead({ titleTemplate: 'Login | Vibe Log' });

  definePageMeta({
    sanctum: {
      guestOnly: true,
    },
  });

  const { login } = useSanctumAuth();

  const form = useForm({
    defaultValues: {
      email: '',
      password: '',
    },
    onSubmit: async ({ value }) => {
      try {
        await login(value);
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
      } catch (error: any) {
        toast.error(error.data?.message);
      }
    },
  });
</script>

<template>
  <div class="flex min-h-screen items-center justify-center">
    <Card class="w-[400px]">
      <CardHeader class="mb-3 flex justify-center text-xl">
        <CardTitle>Welcome Back</CardTitle>
      </CardHeader>
      <CardContent>
        <form @submit.prevent.stop="form.handleSubmit">
          <div class="space-y-3">
            <form.Field
              name="email"
              :validators="{
                onBlur: z.email(),
              }"
            >
              <template #default="{ field, state }">
                <Label :for="field.name">Email</Label>
                <Input
                  :id="field.name"
                  v-model="field.state.value"
                  :name="field.name"
                  placeholder="Enter Email"
                  @blur="field.handleBlur"
                  @input="
                    (e: Event) =>
                      field.handleChange((e.target as HTMLInputElement).value)
                  "
                />
                <InputInfo :state="state" />
              </template>
            </form.Field>
            <form.Field
              name="password"
              :validators="{
                onBlur: z.string().min(8, {
                  error: 'Password must be a minimum of 8 characters',
                }),
              }"
            >
              <template #default="{ field, state }">
                <Label :for="field.name">Password</Label>
                <Input
                  :id="field.name"
                  v-model="field.state.value"
                  :name="field.name"
                  type="password"
                  placeholder="Enter Password"
                  autocomplete="current-password"
                  @blur="field.handleBlur"
                  @input="
                    (e: Event) =>
                      field.handleChange((e.target as HTMLInputElement).value)
                  "
                />
                <InputInfo :state="state" />
              </template>
            </form.Field>
          </div>
          <form.Subscribe>
            <template #default="{ canSubmit, isSubmitting }">
              <Button
                type="submit"
                :disabled="!canSubmit"
                class="mt-5 w-full"
                iconPlacement="right"
                effect="expandIcon"
                :icon="Mail"
              >
                {{ isSubmitting ? 'Logging in...' : 'Continue with Email' }}
              </Button>
            </template>
          </form.Subscribe>
        </form>
      </CardContent>
      <CardFooter class="my-3 flex items-center justify-center px-6">
        <div class="space-y-5">
          <p class="text-center text-sm">
            Don&apos;t have an account?
            <NuxtLink
              to="/register"
              class="text-muted-foreground ml-1 underline"
            >
              Create account
            </NuxtLink>
          </p>
        </div>
      </CardFooter>
    </Card>
  </div>
</template>
