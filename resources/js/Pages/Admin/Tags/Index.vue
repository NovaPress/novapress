<script setup lang="ts">
import type { Tag } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import Textarea from '@/Components/Admin/Forms/Textarea.vue'
import Pagination from '@/Components/Admin/Shared/Pagination.vue'
import Table from '@/Components/Admin/Tables/Table.vue'
import TableRow from '@/Components/Admin/Tables/TableRow.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

defineProps<{
  tags: Tag
  headers: Array<string>
  status?: string
}>()

const form = useForm({
  name: '',
  slug: '',
  description: '',
})

const pageTitle = ref('Tags')

const search = ref('')

watch(search, (value: any) => {
  router.get(
    route('admin.tags.index'),
    { search: value },
    {
      preserveState: true,
      replace: true,
    },
  )
})

function submit() {
  form.post(route('admin.tags.store'), {
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Tags" />

    <!-- Breadcrumb Start -->
    <Breadcrumb v-model="search" :has-search="true" :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 gap-9 sm:grid-cols-3">
      <div class="flex flex-col gap-9">
        <div class="mt-4 font-semibold text-black">
          Add New Tag
        </div>
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
        </div>
        <form @submit.prevent="submit">
          <InputGroup label="Name" :error-message="form.errors.name">
            <Text
              id="name"
              v-model="form.name"
              type="text"
              required
              autofocus
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <InputGroup label="Slug" :error-message="form.errors.slug">
            <Text
              id="slug"
              v-model="form.slug"
              type="text"
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <InputGroup label="Description" :error-message="form.errors.description">
            <Textarea
              id="description"
              v-model="form.description"
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <div class="mb-5 mt-6">
            <input
              type="submit"
              value="Add New Tag"
              class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
            >
          </div>
        </form>
      </div>

      <div class="flex flex-col gap-9 col-span-2">
        <Table :thead="headers">
          <tr v-for="tag in tags.data" :key="tag.id">
            <TableRow
              :item="tag.name"
              :main="true"
              :link="route('admin.tags.show', { tag: tag.id })"
            />
            <TableRow :item="tag.description" />
            <TableRow :item="tag.slug" />
            <TableRow :item="tag.posts_count" />
          </tr>
        </Table>
        <Pagination :links="tags.meta.links" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>
