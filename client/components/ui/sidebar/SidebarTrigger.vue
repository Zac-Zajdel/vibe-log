<script setup lang="ts">
  import { Button } from '@/components/ui/button';
  import { cn } from '@/lib/utils';
  import { PanelLeft } from 'lucide-vue-next';
  import type { HTMLAttributes } from 'vue';
  import { useSidebar } from './utils';

  const props = defineProps<{
    class?: HTMLAttributes['class'];
  }>();

  const { toggleSidebar } = useSidebar();
</script>

<template>
  <Button
    data-sidebar="trigger"
    data-slot="sidebar-trigger"
    variant="ghost"
    size="icon"
    :class="cn('mr-2 size-3 cursor-pointer px-4', props.class)"
    @click="toggleSidebar"
  >
    <PanelLeft class="size-4" />
    <span class="sr-only">Toggle Sidebar</span>
  </Button>
</template>
