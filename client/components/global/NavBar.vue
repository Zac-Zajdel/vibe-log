<script lang="ts" setup>
  import type { Breadcrumbs } from '@/types/breadcrumbs';

  defineProps<{ breadcrumbs?: Breadcrumbs }>();
</script>

<template>
  <div>
    <div class="flex items-center p-4">
      <SidebarTrigger class="mr-3" />
      <div class="mr-4 h-4">
        <Separator orientation="vertical" />
      </div>
      <Breadcrumb>
        <BreadcrumbList>
          <template v-for="breadcrumb in breadcrumbs" :key="breadcrumb.title">
            <BreadcrumbItem>
              <BreadcrumbLink
                v-if="breadcrumb.url"
                :href="breadcrumb.url"
                class="flex items-center"
              >
                <component
                  :is="breadcrumb.icon"
                  v-if="breadcrumb.icon"
                  class="mr-3 size-4"
                />
                {{ breadcrumb.title }}
              </BreadcrumbLink>
              <BreadcrumbPage v-else class="flex items-center">
                <component
                  :is="breadcrumb.icon"
                  v-if="breadcrumb.icon"
                  class="mr-3 size-4"
                />
                {{ breadcrumb.title }}
              </BreadcrumbPage>
            </BreadcrumbItem>
            <BreadcrumbSeparator
              v-if="breadcrumb !== breadcrumbs?.[breadcrumbs.length - 1]"
            />
          </template>
        </BreadcrumbList>
      </Breadcrumb>
    </div>
    <Separator />
  </div>
</template>
