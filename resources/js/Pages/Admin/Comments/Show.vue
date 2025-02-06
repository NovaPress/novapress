<script setup lang="ts">
import type { SingleComment } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import PasswordGenerator from '@/Components/Admin/Forms/PasswordGenerator.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  comment: SingleComment
}>()

const form = useForm({
  author: props.comment.data.author,
  content: props.comment.data.content,
  post: props.comment.data.post,
  submitted_at: props.comment.data.submitted_at,
})

const pageTitle = ref('Edit Comment')

function submit() {
  form.put(route('admin.comments.update', { comment: props.comment.data.id }), {
    onFinish: () => {
      form.reset()
    },
  })
}

function deleteIem() {
  router.delete(
    route('admin.comments.destroy', { comment: props.comment.data.id }),
  )
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Edit Comment" />

    <!-- Breadcrumb Start -->
    <Breadcrumb :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 px-4 sm:px-20 lg:px-80">
      <div class="flex flex-col gap-9">
        <form @submit.prevent="submit">
          <InputGroup label="Author" :error-message="form.errors.author">
            <Text
              id="name"
              v-model="form.author"
              type="text"
              required
              autofocus
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <InputGroup label="Content" :error-message="form.errors.content">
            <Text
              id="email"
              v-model="form.content"
              type="text"
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <InputGroup label="Post" :error-message="form.errors.post">
            <PasswordGenerator v-model="form.post" />
          </InputGroup>

          <InputGroup label="Submitted On" :error-message="form.errors.submitted_at">
            <Text
              id="submitted-on"
              v-model="form.submitted_at"
              type="text"
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <div class="mb-5 mt-6 flex items-center justify-around">
            <input
              type="submit"
              value="Update Comment"
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
