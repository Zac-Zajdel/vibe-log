<script setup lang="ts">
  import type { Breadcrumbs } from '@/types/breadcrumbs';
  import { ArrowLeftIcon, ArrowRightIcon, HomeIcon } from 'lucide-vue-next';
  import ButtonEnhanced from '~/components/ui/button/ButtonEnhanced.vue';

  useHead({ title: 'Home' });

  const colorMode = useColorMode();

  const breadcrumbs: Breadcrumbs = [{ title: 'Home', icon: HomeIcon }];
</script>

<template>
  <PageWrapper :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4">
      <div class="flex gap-2">
        <ButtonEnhanced
          iconPlacement="left"
          effect="expandIcon"
          :icon="ArrowLeftIcon"
          @click="colorMode.preference = 'light'"
        >
          Light
        </ButtonEnhanced>
        <ButtonEnhanced
          iconPlacement="right"
          effect="expandIcon"
          :icon="ArrowRightIcon"
          @click="colorMode.preference = 'dark'"
        >
          Dark
        </ButtonEnhanced>
        <Button @click="colorMode.preference = 'system'">System</Button>
      </div>
    </div>
  </PageWrapper>
</template>
