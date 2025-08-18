<script setup lang="ts">
  import { useUpdateWorkspaceMutation } from '@/hooks/api/workspace/useUpdateWorkspaceMutation';
  import { useUser } from '@/hooks/authentication/useUser';
  import { useForm } from '@tanstack/vue-form';
  import { toast } from 'vue-sonner';
  import { z } from 'zod/v4';

  useHead({
    title: 'Workspace Settings - General',
  });

  const user = useUser();
  const { refreshIdentity } = useSanctumAuth();
  const updateWorkspaceMutation = useUpdateWorkspaceMutation();

  const form = useForm({
    defaultValues: {
      name: user.value.active_workspace?.name ?? '',
      description: user.value.active_workspace?.description ?? '',
      owner_id: user.value.active_workspace?.owner_id ?? 0,
    },
    onSubmit: async ({ value }) => {
      try {
        const payload: App.Data.Request.Workspace.WorkspaceUpdateData = {
          name: value.name,
          owner_id: value.owner_id,
          description: value.description,
        };

        await updateWorkspaceMutation.mutateAsync(payload, {
          onSuccess: ({ message }: { message: string }) => {
            toast.success(message);
            refreshIdentity();
          },
        });
      } catch (error) {
        toast.error('Failed to update workspace settings');
      }
    },
  });
</script>

<template>
  <PageWrapper class="mx-auto max-w-screen-xl">
    <div class="flex flex-col">
      <h1 class="text-2xl font-light">Workspace Settings</h1>
      <p class="text-muted-foreground mt-1 text-sm">
        Update your workspace details and configurations.
      </p>
    </div>
    <Separator class="my-6" />
    <div>
      <Card>
        <CardHeader>
          <CardTitle>Workspace Details</CardTitle>
        </CardHeader>
        <CardContent>
          <form @submit.prevent.stop="form.handleSubmit">
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2 md:col-span-1">
                <form.Field
                  name="name"
                  :validators="{
                    onBlur: z.string().min(1, 'Workspace name is required'),
                  }"
                >
                  <template #default="{ field }">
                    <div class="space-y-2">
                      <Label :for="field.name">Workspace Name</Label>
                      <Input
                        :id="field.name"
                        v-model="field.state.value"
                        :name="field.name"
                        placeholder="Enter workspace name"
                        autocomplete="off"
                        :focus="false"
                        @blur="field.handleBlur"
                        @input="
                          (e: Event) =>
                            field.handleChange(
                              (e.target as HTMLInputElement).value
                            )
                        "
                      />
                    </div>
                  </template>
                </form.Field>
              </div>

              <div class="col-span-2 md:col-span-1">
                <form.Field name="owner_id">
                  <template #default="{ field }">
                    <div class="w-full space-y-2">
                      <Label :for="field.name">Owner</Label>
                      <SelectWorkspaceUser />
                    </div>
                  </template>
                </form.Field>
              </div>

              <div class="col-span-2">
                <form.Field
                  name="description"
                  :validators="{
                    onBlur: z.string(),
                  }"
                >
                  <template #default="{ field }">
                    <div class="space-y-2">
                      <Label :for="field.name">Description</Label>
                      <Textarea
                        :id="field.name"
                        v-model="field.state.value"
                        :name="field.name"
                        placeholder="Enter workspace description"
                        autocomplete="off"
                        :focus="false"
                        @blur="field.handleBlur"
                        @input="
                          (e: Event) =>
                            field.handleChange(
                              (e.target as HTMLInputElement).value
                            )
                        "
                      />
                    </div>
                  </template>
                </form.Field>
              </div>
            </div>

            <form.Subscribe>
              <template #default="{ canSubmit, isSubmitting }">
                <div class="mt-5 flex justify-end">
                  <Button type="submit" :disabled="!canSubmit">
                    {{ isSubmitting ? 'Saving...' : 'Save' }}
                  </Button>
                </div>
              </template>
            </form.Subscribe>
          </form>
        </CardContent>
      </Card>
    </div>
  </PageWrapper>
</template>
