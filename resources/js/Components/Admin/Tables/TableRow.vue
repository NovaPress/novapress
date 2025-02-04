<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

defineProps<{
  item?: string | number
  main?: boolean
  link?: string
}>()
</script>

<template>
  <td class="py-5 px-4">
    <p
      v-if="item"
      class="text-black dark:text-white"
      :class="{ 'font-medium': main, 'hover:text-primary underline dark:hover:text-primary': link }"
    >
      <Link v-if="link" :href="link">
        {{ item }}
      </Link>
      <span v-else>
        {{ item }}
      </span>
    </p>
    <slot v-else />
  </td>
</template>
