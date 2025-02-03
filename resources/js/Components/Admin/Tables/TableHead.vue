<script setup lang="ts">
defineProps<{
  title: string
}>()
</script>

<template>
  <th class="py-4 px-4 font-medium text-black dark:text-white">
    {{ title }}
  </th>
</template>
