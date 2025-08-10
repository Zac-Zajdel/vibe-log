<script setup lang="ts">
  import { MoonStar, Sun } from 'lucide-vue-next';

  useHead({ title: 'Home' });

  const colorMode = useColorMode();
</script>

<template>
  <PageWrapper>
    <div class="flex flex-col gap-4">
      <div class="flex gap-2">
        <Button
          iconPlacement="left"
          effect="expandIcon"
          :icon="Sun"
          @click="colorMode.preference = 'light'"
        >
          Light
        </Button>
        <Button
          iconPlacement="right"
          effect="expandIcon"
          :icon="MoonStar"
          @click="colorMode.preference = 'dark'"
        >
          Dark
        </Button>
        <Button @click="colorMode.preference = 'system'">System</Button>
      </div>
    </div>
  </PageWrapper>
</template>
