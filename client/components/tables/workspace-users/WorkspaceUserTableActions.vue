<script setup lang="ts">
  import { Button } from '@/components/ui/button';
  import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
  } from '@/components/ui/dropdown-menu';
  import { MoreHorizontal } from 'lucide-vue-next';

  defineProps<{
    payment: {
      id: number;
    };
  }>();

  function copy(id: number) {
    navigator.clipboard.writeText(id.toString());
  }
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="size-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="size-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuItem @click="copy(payment.id)">
        Copy User ID
      </DropdownMenuItem>
      <DropdownMenuItem>Disable User</DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
