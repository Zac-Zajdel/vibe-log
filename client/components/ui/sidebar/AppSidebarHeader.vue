<script setup lang="ts">
  import { useWorkspacesQuery } from '@/hooks/api/workspace/useWorkspacesQuery';
  import { ChevronDown } from 'lucide-vue-next';

  const { workspaces } = useWorkspacesQuery(1, 10);
</script>

<template>
  <SidebarHeader class="mt-2 group-data-[collapsible=icon]:hidden">
    <SidebarMenu>
      <SidebarMenuItem>
        <DropdownMenu>
          <!--eslint-disable-next-line vue/attribute-hyphenation -->
          <DropdownMenuTrigger asChild>
            <SidebarMenuButton>
              Default Workspace
              <ChevronDown class="ml-auto" />
            </SidebarMenuButton>
          </DropdownMenuTrigger>
          <DropdownMenuContent class="w-48">
            <DropdownMenuItem
              v-for="workspace in workspaces"
              :key="workspace.id"
              class="text-xs"
            >
              <span>{{ workspace.name }}</span>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarHeader>
</template>
