<script setup lang="ts">
  import { useStoreWorkspaceMutation } from '@/hooks/api/workspace/useStoreWorkspaceMutation';
  import { useUser } from '@/hooks/authentication/useUser';
  import { useForm } from '@tanstack/vue-form';
  import { useQueryClient } from '@tanstack/vue-query';
  import { Plus } from 'lucide-vue-next';
  import { toast } from 'vue-sonner';
  import { z } from 'zod/v4';

  const user = useUser();
  const queryClient = useQueryClient();
  const updateUserMutation = useStoreWorkspaceMutation();

  const open = ref(false);

  const form = useForm({
    defaultValues: {
      name: '',
      description: '',
    },
    onSubmit: async ({ value }) => {
      const payload: App.Data.Request.Workspace.WorkspaceStoreData = {
        owner_id: user.value.id,
        name: value.name,
        description: value.description,
      };

      updateUserMutation.mutateAsync(payload, {
        onSuccess: async ({ message }: { message: string }) => {
          toast.success(message);

          // Updates the sidebar options within the dropdown menu.
          queryClient.invalidateQueries({
            queryKey: ['workspaces'],
          });

          open.value = false;
        },
      });
    },
  });
</script>

<template>
  <Dialog v-model:open="open">
    <DialogTrigger class="w-full cursor-pointer">
      <div
        class="hover:bg-muted flex cursor-pointer items-center justify-between rounded-sm px-2 py-1.5 text-xs"
      >
        <span>Create Workspace</span>
        <Plus class="text-primary" :size="15" />
      </div>
    </DialogTrigger>
    <DialogContent>
      <DialogHeader class="mb-2">
        <DialogTitle>Create Workspace</DialogTitle>
        <DialogDescription>
          Make changes to your profile here. Click save when you're done.
        </DialogDescription>
      </DialogHeader>

      <form @submit.prevent.stop="form.handleSubmit">
        <div class="space-y-2">
          <form.Field
            name="name"
            :validators="{
              onBlur: z.string().min(3).max(255),
            }"
          >
            <template #default="{ field, state }">
              <Label :for="field.name">Name</Label>
              <Input
                :id="field.name"
                v-model="field.state.value"
                :name="field.name"
                placeholder="Enter Name"
                autocomplete="off"
                :focus="false"
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

        <div class="space-y-2">
          <form.Field
            name="description"
            :validators="{
              onBlur: z.string().min(3).max(255),
            }"
          >
            <template #default="{ field, state }">
              <Label :for="field.name">Description</Label>
              <Input
                :id="field.name"
                v-model="field.state.value"
                :name="field.name"
                autocomplete="off"
                :focus="false"
                placeholder="Enter Description"
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
            <DialogFooter>
              <Button type="submit" :disabled="!canSubmit" class="mt-3">
                {{ isSubmitting ? 'Creating...' : 'Create' }}
              </Button>
            </DialogFooter>
          </template>
        </form.Subscribe>
      </form>
    </DialogContent>
  </Dialog>
</template>
