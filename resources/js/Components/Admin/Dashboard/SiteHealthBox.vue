<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <div class="flex flex-col w-full">
    <div class="flex items-center px-4 h-10 border-b border-stroke dark:border-strokedark">
      <span class="text-black dark:text-white">Site Health Status</span>
    </div>
    <div class="grid grid-cols-3 items-center p-4">
      <span class="col-span-1">Site Status</span>
      <p class="col-span-2 text-sm text-black dark:text-white">
        Your site's health is looking good, but there are still some things you can do
        to improve its performance and security.
        <br><br>
        Take a look at the 5 items on the
        <Link href="#" class="underline text-primary">
          Site Health Page.
        </Link>
      </p>
    </div>
  </div>
</template>
