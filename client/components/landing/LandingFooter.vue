<script setup lang="ts">
  import Github from '@/components/ui/icons/Github.vue';
</script>

<template>
  <footer>
    <div class="flex items-center justify-between py-5">
      <div class="ml-4 flex items-center text-base">
        <p class="text-muted-foreground">Built in open source by&nbsp;</p>
        <NuxtLink
          class="font-medium hover:underline"
          href="https://github.com/Zac-Zajdel"
          target="_blank"
        >
          Zac Zajdel
        </NuxtLink>
      </div>
      <div>
        <NuxtLink href="https://github.com/Zac-Zajdel/vibe-log" target="_blank">
          <Button variant="outline" size="icon" aria-label="Github">
            <Github />
          </Button>
        </NuxtLink>
      </div>
    </div>
  </footer>
</template>
