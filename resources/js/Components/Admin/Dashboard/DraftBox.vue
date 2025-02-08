<script setup lang="ts">
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import Textarea from '@/Components/Admin/Forms/Textarea.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  title: '',
  content: '',
})

function submit() {
  form.post(route('admin.store-draft'), {
    onSuccess: () => {
      form.reset()
    },
  })
}
</script>

<template>
  <div class="flex flex-col w-full">
    <div class="flex items-center px-4 h-10 border-b border-stroke dark:border-strokedark">
      <span class="text-black dark:text-white">Quick Draft</span>
    </div>
    <div class="grid grid-cols-1 items-center p-4 space-y-2">
      <form @submit.prevent="submit">
        <InputGroup label="Title" :error-message="form.errors.title">
          <Text
            id="title"
            v-model="form.title"
            name="title"
            type="text"
            required
          />
        </InputGroup>

        <InputGroup label="Content" :error-message="form.errors.content">
          <Textarea
            id="content"
            v-model="form.content"
            class="bg-white dark:bg-boxdark dark:text-white"
            rows="5"
          />
        </InputGroup>
        <div class="mb-5 mt-6">
          <button
            type="submit"
            class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
          >
            Save Draft
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
