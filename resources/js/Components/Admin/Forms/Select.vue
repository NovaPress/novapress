<script setup lang="ts">
defineProps<{
  items: {
    name: string
    value: string
    selected: boolean
  }[]
}>()

const model = defineModel()
</script>

<template>
  <select
    v-model="model"
    class="relative z-20 w-full appearance-none rounded border border-stroke bg-white py-3 px-5 outline-none
          transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input
          dark:focus:border-primary text-black dark:text-white"
    :items="items"
  >
    <option
      v-for="(item, index) in items"
      :key="index"
      :value="item.value"
      :selected="item.selected"
    >
      {{ item.name }}
    </option>
  </select>
</template>
