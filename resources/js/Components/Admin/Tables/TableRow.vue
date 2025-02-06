<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

defineProps<{
  item?: string | number
  main?: boolean
  link?: string
  capitalize?: boolean
}>()
</script>

<template>
  <td class="py-5 px-4">
    <p
      v-if="item !== null"
      class="text-black dark:text-white"
      :class="{ 'font-medium': main, 'hover:text-primary underline dark:hover:text-primary': link, capitalize }"
    >
      <Link v-if="link" :href="link">
        {{ item }}
      </Link>
      <span v-else :class="{ capitalize }">
        {{ item }}
      </span>
    </p>
    <slot v-else />
  </td>
</template>
