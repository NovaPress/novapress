<script setup lang="ts">
import type { PaginationLinks } from '@/types'
import { Link } from '@inertiajs/vue3'

defineProps<{
  links: PaginationLinks[]
}>()
</script>

<template>
  <div v-if="links.length > 3">
    <div class="flex flex-wrap justify-center items-center w-full">
      <template v-for="(link, key) in links" :key="key">
        <div
          v-if="link.url === null"
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
          v-html="link.label"
        />

        <Link
          v-else
          class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
          :class="{ 'bg-white': link.active }"
          :href="link.url"
        >
          <span v-html="link.label" />
        </Link>
      </template>
    </div>
  </div>
</template>
