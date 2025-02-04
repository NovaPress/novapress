<script setup lang="ts">
import TableHead from '@/Components/Admin/Tables/TableHead.vue'

defineProps<{
  thead: Array<string>
}>()
</script>

<template>
  <div
    class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-default dark:border-strokedark
      dark:bg-boxdark sm:px-7.5 xl:pb-1"
  >
    <div class="max-w-full overflow-x-auto">
      <table class="w-full table-auto" :thead="thead">
        <thead>
          <tr class="bg-gray-2 text-left dark:bg-meta-4">
            <TableHead
              v-for="(head, index) in thead"
              :key="index"
              :title="head"
            />
          </tr>
        </thead>
        <tbody>
          <slot />
        </tbody>
      </table>
    </div>
  </div>
</template>
