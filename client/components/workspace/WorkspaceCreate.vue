<script setup lang="ts">
  import { useStoreWorkspaceMutation } from '@/hooks/api/workspace/useStoreWorkspaceMutation';
  import { useUser } from '@/hooks/authentication/useUser';
  import { useQueryClient } from '@tanstack/vue-query';
  import { Plus } from 'lucide-vue-next';
  import { toast } from 'vue-sonner';

  const user = useUser();
  const queryClient = useQueryClient();
  const updateUserMutation = useStoreWorkspaceMutation();

  const open = ref(false);
  const workspaceContent = reactive({
    name: '',
    description: '',
  });

  async function createWorkspace() {
    const payload: App.Data.Request.Workspace.WorkspaceStoreData = {
      owner_id: user.value.id,
      name: workspaceContent.name,
      description: workspaceContent.description,
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
  }
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

      <div class="space-y-2">
        <Label for="name">Name</Label>
        <Input
          id="name"
          v-model="workspaceContent.name"
          placeholder="Enter Name"
        />
      </div>

      <div class="space-y-2">
        <Label for="description">Description</Label>
        <Input
          id="description"
          v-model="workspaceContent.description"
          placeholder="Enter Description"
        />
      </div>

      <DialogFooter @click="createWorkspace">
        <Button class="cursor-pointer">Create</Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
