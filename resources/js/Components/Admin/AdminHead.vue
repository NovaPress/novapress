<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3'

defineProps({ title: String })

const page = usePage()
const appName = page.props.appName
</script>

<template>
  <Head :title="title ? `${title} - ${appName}` : `${appName}`">
    <slot />
  </Head>
</template>
