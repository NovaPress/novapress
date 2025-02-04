<script setup lang="ts">
import type { Filters, Post } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import Pagination from '@/Components/Admin/Shared/Pagination.vue'
import Table from '@/Components/Admin/Tables/Table.vue'
import TableRow from '@/Components/Admin/Tables/TableRow.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps<{
  posts: Post
  headers: Array<string>
  filters: Filters
}>()

const pageTitle = ref('Posts')

const search = ref(props.filters.search)
watch(search, (value: any) => {
  router.get(
    route('admin.posts.index'),
    { search: value },
    {
      preserveState: true,
      replace: true,
    },
  )
})
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Posts" />

    <!-- Breadcrumb Start -->
    <Breadcrumb v-model="search" :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="flex flex-col gap-10">
      <Table :thead="headers">
        <tr v-for="post in posts.data" :key="post.id">
          <TableRow :items="[post.title]" :main="true" />
          <TableRow :items="[post.author]" />
          <TableRow :items="post.categories" />
          <TableRow items="0" />
          <TableRow items="0" />
          <TableRow :items="[post.published_at]" />
        </tr>
      </Table>
      <Pagination :links="posts.links" />
    </div>
  </AuthenticatedLayout>
</template>
