<script setup lang="ts">
import type { Comment } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import Pagination from '@/Components/Admin/Shared/Pagination.vue'
import Table from '@/Components/Admin/Tables/Table.vue'
import TableRow from '@/Components/Admin/Tables/TableRow.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

defineProps<{
  comments: Comment
  headers: Array<string>
}>()

const pageTitle = ref('Comments')

const search = ref('')
watch(search, (value: any) => {
  router.get(
    route('admin.comments.index'),
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
    <Head title="Comments" />

    <!-- Breadcrumb Start -->
    <Breadcrumb v-model="search" :has-search="true" :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="flex flex-col gap-10">
      <Table :thead="headers">
        <tr v-for="comment in comments.data" :key="comment.id">
          <TableRow
            :item="comment.author"
            :main="true"
          />
          <TableRow :item="comment.content" />
          <TableRow :item="comment.post"/>
          <TableRow :item="comment.submitted_at" />
        </tr>
      </Table>
      <Pagination :links="comments.meta.links" />
    </div>
  </AuthenticatedLayout>
</template>
