<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

const glanceData: any = defineModel()
</script>

<template>
  <div class="flex flex-col w-full">
    <div class="flex items-center px-4 h-10 border-b border-stroke dark:border-strokedark">
      <span class="text-black dark:text-white">At a Glance</span>
    </div>
    <div class="grid grid-cols-2 items-center p-4 space-y-2">
      <Link href="#" class="text-primary">
        {{ glanceData.posts }} Post
      </Link>
      <Link href="#" class="text-primary">
        {{ glanceData.pages }} Page
      </Link>
      <Link href="#" class="text-primary">
        {{ glanceData.comments }} Comment
      </Link>
      <Link href="#" class="text-primary">
        {{ glanceData.spam }} Spam
      </Link>
      <span class="col-span-2 pt-4 text-black dark:text-white font-semibold">NovaPress 1.0.0</span>
    </div>
  </div>
</template>
