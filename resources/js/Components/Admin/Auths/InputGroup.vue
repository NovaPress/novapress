<script setup lang="ts">
import InputLabel from '@/Components/Admin/Auths/InputLabel.vue'

defineProps<{
  label?: string
  errorMessage?: string
}>()
</script>

<template>
  <div class="mb-4">
    <InputLabel :label="label" />
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
