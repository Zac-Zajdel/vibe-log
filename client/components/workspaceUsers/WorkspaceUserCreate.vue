<script setup lang="ts">
  import { useStoreWorkspaceUserMutation } from '@/hooks/api/workspaceUser/useStoreWorkspaceUserMutation';
  import { useForm } from '@tanstack/vue-form';
  import { useQueryClient } from '@tanstack/vue-query';
  import { toast } from 'vue-sonner';
  import { z } from 'zod/v4';

  const queryClient = useQueryClient();
  const storeWorkspaceUserMutation = useStoreWorkspaceUserMutation();

  const open = ref(false);

  const form = useForm({
    defaultValues: {
      email: '',
      role: 'member' as App.Enums.Workspace.WorkspaceUserRole,
    },
    onSubmit: async ({ value }) => {
      const payload: App.Data.Request.WorkspaceUser.WorkspaceUserStoreData = {
        email: value.email,
        role: value.role,
      };

      storeWorkspaceUserMutation.mutateAsync(payload, {
        onSuccess: async ({ message }: { message: string }) => {
          toast.success(message);

          queryClient.invalidateQueries({
            queryKey: ['workspace-users'],
          });

          open.value = false;
        },
      });
    },
  });
</script>

<template>
  <Dialog v-model:open="open">
    <DialogTrigger as-child>
      <Button>Invite User</Button>
    </DialogTrigger>
    <DialogContent>
      <DialogHeader class="mb-2">
        <DialogTitle>Invite New User</DialogTitle>
        <DialogDescription>
          Invite a new user to your workspace for collaboration.
        </DialogDescription>
      </DialogHeader>

      <form @submit.prevent.stop="form.handleSubmit">
        <div class="space-y-2">
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
            name="role"
            :validators="{
              onBlur: z.enum([
                'member',
                'member',
                'admin',
              ] as App.Enums.Workspace.WorkspaceUserRole[]),
            }"
          >
            <template #default="{ field }">
              <Label :for="field.name">Role</Label>
              <Select
                :model-value="field.state.value"
                @update:modelValue="
                  (val) =>
                    field.handleChange(
                      val as App.Enums.Workspace.WorkspaceUserRole
                    )
                "
              >
                <SelectTrigger class="w-full">
                  <SelectValue placeholder="Select a role" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectItem value="member">Member</SelectItem>
                    <SelectItem value="viewer">Viewer</SelectItem>
                    <SelectItem value="admin">Admin</SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>
            </template>
          </form.Field>
        </div>

        <form.Subscribe>
          <template #default="{ canSubmit, isSubmitting }">
            <DialogFooter>
              <Button type="submit" :disabled="!canSubmit" class="mt-3">
                {{ isSubmitting ? 'Inviting...' : 'Invite' }}
              </Button>
            </DialogFooter>
          </template>
        </form.Subscribe>
      </form>
    </DialogContent>
  </Dialog>
</template>
