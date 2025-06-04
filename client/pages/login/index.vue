<script setup lang="ts">
  import { toTypedSchema } from '@vee-validate/zod';
  import { useForm } from 'vee-validate';
  import * as z from 'zod';

  useHead({ titleTemplate: 'Login | Vibe Log' });

  definePageMeta({
    sanctum: {
      guestOnly: true,
    },
  });

  const formSchema = toTypedSchema(
    z.object({
      email: z.string().min(1),
      password: z.string().min(1),
    })
  );

  const { isFieldDirty, handleSubmit } = useForm({
    validationSchema: formSchema,
  });

  const { login } = useSanctumAuth();
  const onSubmit = handleSubmit(async (values) => {
    try {
      await login(values);
    } catch (err) {
      console.log(err);
    }
  });
</script>

<template>
  <div class="flex min-h-screen items-center justify-center">
    <Card class="w-[400px]">
      <CardHeader class="mb-3 flex justify-center text-xl">
        <CardTitle>Welcome Back</CardTitle>
      </CardHeader>
      <CardContent>
        <form
          class="w-full space-y-4"
          :validation-schema="formSchema"
          @submit="onSubmit"
        >
          <FormField v-slot="{ componentField }" name="email">
            <FormItem>
              <FormLabel>Email</FormLabel>
              <FormControl>
                <Input
                  type="text"
                  v-bind="componentField"
                  placeholder="johndoe@gmail.com"
                />
              </FormControl>
            </FormItem>
          </FormField>
          <FormField
            v-slot="{ componentField }"
            name="password"
            :validate-on-blur="!isFieldDirty"
          >
            <FormItem>
              <FormLabel>Password</FormLabel>
              <FormControl>
                <Input
                  type="password"
                  v-bind="componentField"
                  placeholder="Password"
                />
              </FormControl>
            </FormItem>
          </FormField>
          <Button type="submit" class="mt-4 w-full">Continue with Email</Button>
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
