<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

defineProps<{
  items: Array<string | number> | string | number
  main?: boolean
  link?: string
}>()
</script>

<template>
  <td v-if="items.length === 1" class="py-5 px-4">
    <Link v-if="link" :href="link">
      <p
        class="text-black dark:text-white hover:text-primary underline dark:hover:text-primary"
        :class="{ 'font-medium': main }"
      >
        {{ items[0] }}
      </p>
    </Link>
    <p
      v-else
      class="text-black dark:text-white"
      :class="{ 'font-medium': main }"
    >
      {{ items[0] }}
    </p>
  </td>
  <td v-else class="py-5 px-4">
    <Link v-if="link" :href="link">
      <p
        v-for="(item, index) in items"
        :key="index"
        class="text-black dark:text-white hover:text-primary underline dark:hover:text-primary"
        :class="{ 'font-medium': main }"
      >
        {{ item }}
      </p>
    </Link>
    <p
      v-for="(item, index) in items"
      v-else
      :key="index"
      class="text-black dark:text-white"
      :class="{ 'font-medium': main }"
    >
      {{ item }}
    </p>
  </td>
</template>
