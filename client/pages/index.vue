<script setup lang="ts">
  import { motion } from 'motion-v';

  useHead({ titleTemplate: 'Vibe Log' });
</script>

<template>
  <div>
    <LandingNavBar />
    <div class="mt-24 flex justify-center space-y-6 text-center">
      <div class="max-w-[650px] space-y-6">
        <motion.h1
          class="text-6xl font-medium tracking-wide text-pretty"
          :initial="{ opacity: 0, scale: 0.5 }"
          :animate="{ opacity: 1, scale: 1 }"
          :transition="{
            duration: 0.8,
            delay: 0.1,
            ease: [0, 0.71, 0.2, 1.01],
          }"
        >
          The All-In-One Platform For Modern Workflows
        </motion.h1>
        <motion.h2
          class="text-xl text-pretty text-gray-600 dark:text-gray-300"
          :initial="{ opacity: 0, scale: 0.5, y: 40 }"
          :animate="{ opacity: 1, scale: 1, y: 0 }"
          :transition="{
            duration: 1,
            delay: 0.5,
            ease: [0, 0.71, 0.2, 1.01],
          }"
        >
          Seamlessly connect your tools, tasks, and teams. Unlock a new era of
          productivity with powerful in-app integrations and effortless
          collaboration.
        </motion.h2>
      </div>
    </div>
  </div>
</template>
