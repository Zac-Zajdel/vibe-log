<script setup lang="ts">
  defineProps<{
    label: string;
  }>();
</script>

<template>
  <div class="space-y-2">
    <Label>{{ label }}</Label>
    <Skeleton v-bind="$attrs" />
  </div>
</template>
