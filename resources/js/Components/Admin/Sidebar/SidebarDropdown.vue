<script setup lang="ts">
import { useSidebarStore } from '@/Stores/sidebar'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps(['items', 'page'])

const sidebarStore = useSidebarStore()

const items = ref(props.items)

function handleItemClick(index: number) {
  sidebarStore.selected = sidebarStore.selected === props.items[index].label ? '' : props.items[index].label
}
</script>

<template>
  <ul class="mt-4 mb-5.5 flex flex-col gap-2.5 pl-6">
    <template v-for="(childItem, index) in items" :key="index">
      <li>
        <Link
          :href="childItem.route"
          class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300
            ease-in-out hover:text-white"
          :class="{ '!text-white': childItem.label === sidebarStore.selected }"
          @click="handleItemClick(index)"
        >
          {{ childItem.label }}
        </Link>
      </li>
    </template>
  </ul>
</template>
