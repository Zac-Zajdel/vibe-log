<script setup lang="ts">
  import type { AnyFieldApi } from '@tanstack/vue-form';

  const props = defineProps<{
    state: AnyFieldApi['state'];
  }>();
</script>

<template>
  <div class="mb-5">
    <template v-if="props.state.meta.isTouched">
      <em
        v-for="(error, index) of props.state.meta.errors"
        :key="index"
        class="text-destructive-foreground text-sm"
      >
        {{ error.message }}
      </em>
      {{ props.state.meta.isValidating ? 'Validating...' : null }}
    </template>
  </div>
</template>
