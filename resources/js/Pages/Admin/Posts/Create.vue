<script setup lang="ts">
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import Editor from '@/Components/Admin/Editor.vue'
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const pageTitle = ref('Create New Post')

const form = useForm({
  title: '',
  content: '',
})

function submitForm() {
  form.post(route('admin.posts.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Create New Post" />

    <!-- Breadcrumb Start -->
    <Breadcrumb :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 px-4 sm:px-20 lg:px-40">
      <div class="flex flex-col gap-9">
        <form class="space-y-8" @submit.prevent="submitForm">
          <InputGroup label="Title" :error-message="form.errors.title">
            <Text
              id="name"
              v-model="form.title"
              type="text"
              required
              autofocus
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <Editor v-model="form.content" />

          <div class="mb-5 mt-6 flex items-center justify-around">
            <input
              type="submit"
              value="Create Post"
              class="w-40 cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
            >
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
