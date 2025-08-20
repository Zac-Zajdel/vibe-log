<script setup lang="ts">
  import { useUpdateWorkspaceMutation } from '@/hooks/api/workspace/useUpdateWorkspaceMutation';
  import { useWorkspaceQuery } from '@/hooks/api/workspace/useWorkspaceQuery';
  import { useForm } from '@tanstack/vue-form';
  import { useQueryClient } from '@tanstack/vue-query';
  import { toast } from 'vue-sonner';
  import { z } from 'zod/v4';

  useHead({
    title: 'Workspace Settings - General',
  });

  const queryClient = useQueryClient();
  const { refreshIdentity } = useSanctumAuth();

  const updateWorkspaceMutation = useUpdateWorkspaceMutation();
  const { workspace, isLoading } = useWorkspaceQuery();

  const name = computed((): string => workspace.value?.name ?? '');
  const description = computed(
    (): string => workspace.value?.description ?? ''
  );
  const ownerId = computed((): number => workspace.value?.owner_id ?? 0);

  const form = useForm({
    defaultValues: reactive({
      name,
      description,
      ownerId,
    }),
    onSubmit: async ({ value }) => {
      const payload: App.Data.Request.Workspace.WorkspaceUpdateData = {
        name: value.name,
        owner_id: value.ownerId,
        description: value.description,
      };

      await updateWorkspaceMutation.mutateAsync(payload, {
        onSuccess: ({ message }: { message: string }) => {
          toast.success(message);
          refreshIdentity();

          queryClient.invalidateQueries({
            queryKey: ['workspace'],
          });
        },
      });
    },
  });

  const handleOwnerSelect = (
    owner: App.Data.Resource.WorkspaceUser.WorkspaceUserResource
  ) => {
    form.setFieldValue('ownerId', owner.user_id);
  };
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
      <Card v-if="!isLoading">
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
                <form.Field name="ownerId">
                  <template #default="{ field }">
                    <div class="w-full space-y-2">
                      <Label :for="field.name">Owner</Label>
                      <SelectWorkspaceUser
                        :owner="workspace?.owner"
                        @select="handleOwnerSelect"
                      />
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
      <Card v-else>
        <CardHeader>
          <CardTitle>Workspace Details</CardTitle>
        </CardHeader>
        <CardContent>
          <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2 space-y-2 md:col-span-1">
              <InputSkeleton label="Workspace Name" :class="'h-9 w-full'" />
            </div>
            <div class="col-span-2 space-y-2 md:col-span-1">
              <InputSkeleton label="Owner" :class="'h-9 w-full'" />
            </div>
            <div class="col-span-2 mt-7.5 space-y-2">
              <InputSkeleton label="Description" :class="'h-16 w-full'" />
            </div>
          </div>
          <div class="mt-10 flex justify-end">
            <Skeleton class="h-10 w-16" />
          </div>
        </CardContent>
      </Card>
    </div>
  </PageWrapper>
</template>
