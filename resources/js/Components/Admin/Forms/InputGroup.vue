<script setup lang="ts">
import Label from '@/Components/Admin/Forms/Label.vue'

defineProps<{
  label?: string
  errorMessage?: string
}>()
</script>

<template>
  <div class="mb-4">
    <Label :label="label" />
    <div class="relative">
      <slot />
    </div>
    <div v-show="errorMessage">
      <p class="mt-2 text-sm text-red-600">
        {{ errorMessage }}
      </p>
    </div>
  </div>
</template>
