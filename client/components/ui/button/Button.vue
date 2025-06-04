<script setup lang="ts">
  import { cn } from '@/lib/utils';
  import { Primitive, type PrimitiveProps } from 'reka-ui';
  import type { HTMLAttributes } from 'vue';
  import { type ButtonVariants, buttonVariants } from '.';

  interface Props extends PrimitiveProps {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    effect?: 'expandIcon';
    icon?: Component;
    iconPlacement?: 'left' | 'right';
    class?: HTMLAttributes['class'];
  }

  const props = withDefaults(defineProps<Props>(), {
    as: 'button',
  });
</script>

<template>
  <Primitive
    data-slot="button"
    :as="as"
    :as-child="asChild"
    :class="
      cn('group cursor-pointer', buttonVariants({ variant, size }), props.class)
    "
  >
    <!-- Left icon -->
    <template v-if="icon && iconPlacement === 'left'">
      <template v-if="effect === 'expandIcon'">
        <div
          class="-mr-2 w-0 translate-x-[-100%] opacity-0 transition-all duration-200 group-hover:w-5 group-hover:translate-x-0 group-hover:pr-6 group-hover:opacity-100"
        >
          <component :is="icon" />
        </div>
      </template>
      <template v-else>
        <component :is="icon" />
      </template>
    </template>

    <slot />

    <!-- Right icon -->
    <template v-if="icon && iconPlacement === 'right'">
      <template v-if="effect === 'expandIcon'">
        <div
          class="-ml-2 w-0 translate-x-[100%] opacity-0 transition-all duration-200 group-hover:w-5 group-hover:translate-x-0 group-hover:pl-2 group-hover:opacity-100"
        >
          <component :is="icon" />
        </div>
      </template>
      <template v-else>
        <component :is="icon" />
      </template>
    </template>
  </Primitive>
</template>
