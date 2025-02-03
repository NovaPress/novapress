<script setup lang="ts">
import { onMounted, ref } from 'vue'

const model = defineModel<string>({ required: true })

const input = ref<HTMLInputElement | null>(null)

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus()
  }
})

defineExpose({ focus: () => input.value?.focus() })
</script>

<template>
  <input
    ref="input"
    v-model="model"
    class="w-full rounded-lg border border-stroke bg-transparent py-4 pl-6 pr-10 outline-none
      focus:border-primary focus-visible:shadow-none text-black"
  >
</template>
