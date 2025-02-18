<script setup lang="ts">
import type { SingleTag } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import Textarea from '@/Components/Admin/Forms/Textarea.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  tag: SingleTag
}>()

const form = useForm({
  name: props.tag.data.name,
  slug: props.tag.data.slug,
  description: props.tag.data.description,
})

const pageTitle = ref('Edit Tag')

function update() {
  form.put(route('admin.tags.update', props.tag.data.id), {
    onFinish: () => {
      form.reset('name', 'slug', 'description')
    },
  })
}

function deleteIem() {
  router.delete(
    route('admin.tags.destroy', { tag: props.tag.data.id }),
  )
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Tags" />

    <!-- Breadcrumb Start -->
    <Breadcrumb :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 px-4 sm:px-20">
      <div class="flex flex-col gap-9">
        <form @submit.prevent="update">
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

          <div class="mb-5 mt-6 flex items-center justify-around">
            <input
              type="submit"
              value="Update"
              class="w-40 cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
            >
            <button
              class="w-40 cursor-pointer rounded-lg border border-danger bg-danger p-4 font-medium text-white
                transition hover:bg-opacity-90"
              @click.prevent="deleteIem"
            >
              Delete
            </button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
