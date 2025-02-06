<script setup lang="ts">
defineProps<{
  label?: string
}>()
</script>

<template>
  <label class="mb-2.5 block font-medium text-black dark:text-white">
    <span v-if="label">{{ label }}</span>
    <span v-else>slot /></span>
  </label>
</template>
