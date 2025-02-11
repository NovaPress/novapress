<script setup lang="ts">
import Label from '@/Components/Admin/Forms/Label.vue'

defineProps<{
  label?: string
  errorMessage?: string
  cols?: number
}>()
</script>

<template>
  <div v-if="!cols" class="mb-4">
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
  <div v-else-if="cols === 2" class="grid grid-cols-1 sm:grid-cols-4 md:grid-cols-6 mb-4">
    <div class="col-span-1 flex items-center">
      <Label :label="label" class="mt-2.5" />
    </div>
    <div class="col-span-1 sm:col-span-3 md:col-span-5">
      <div class="relative">
        <slot />
      </div>
      <div v-show="errorMessage">
        <p class="mt-2 text-sm text-red-600">
          {{ errorMessage }}
        </p>
      </div>
    </div>
  </div>
</template>
