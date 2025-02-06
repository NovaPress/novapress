<script setup lang="ts">
import type { User } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import Pagination from '@/Components/Admin/Shared/Pagination.vue'
import Table from '@/Components/Admin/Tables/Table.vue'
import TableRow from '@/Components/Admin/Tables/TableRow.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

defineProps<{
  users: User
  headers: Array<string>
}>()

const pageTitle = ref('Users')

const search = ref('')
watch(search, (value: any) => {
  router.get(
    route('admin.users.index'),
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
    <Head title="Users" />

    <!-- Breadcrumb Start -->
    <Breadcrumb v-model="search" :has-search="true" :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="flex flex-col gap-10">
      <Table :thead="headers">
        <tr v-for="user in users.data" :key="user.id">
          <TableRow
            :item="user.name"
            :main="true"
            :link="route('admin.users.show', { user: user.id })"
          />
          <TableRow :item="user.email" />
          <TableRow :item="user.role" :capitalize="true" />
          <TableRow :item="user.posts_count" />
        </tr>
      </Table>
      <Pagination :links="users.meta.links" />
    </div>
  </AuthenticatedLayout>
</template>
