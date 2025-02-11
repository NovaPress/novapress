<script setup lang="ts">
defineProps<{
  id: string
  label: string
  value: string
}>()

const model = defineModel()
</script>

<template>
  <div class="flex items-center gap-x-4 py-4">
    <input
      :id="id"
      v-model="model"
      :name="id"
      type="radio"
      :value="value"
      class="w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary focus:ring-2"
    >
    <label
      :for="id"
      class="ms-2 text-sm font-medium text-black dark:text-white"
    >
      {{ label }}
    </label>
  </div>
</template>
