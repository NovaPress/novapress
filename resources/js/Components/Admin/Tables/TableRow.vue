<script setup lang="ts">
defineProps<{
  item: string
  main?: boolean
}>()
</script>

<template>
  <td v-if="main" class="py-5 px-4 pl-9 xl:pl-11">
    <h5 class="font-medium text-black dark:text-white">
      {{ item }}
    </h5>
  </td>
  <td v-else class="py-5 px-4">
    <p class="text-black dark:text-white">
      {{ item }}
    </p>
  </td>
</template>
