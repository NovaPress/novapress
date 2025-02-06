<script setup lang="ts">
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import GuestLayout from '@/Layouts/Admin/GuestLayout.vue'
import { useForm } from '@inertiajs/vue3'

defineProps<{
  status?: string
}>()

const form = useForm({
  email: '',
})

function submit() {
  form.post(route('admin.password.email'))
}
</script>

<template>
  <GuestLayout>
    <div class="mb-4 text-sm text-gray-600">
      Forgot your password? No problem. Just let us know your email address and we will email you
      a password reset link that will allow you to choose a new one.
    </div>
    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>
    <form @submit.prevent="submit">
      <InputGroup label="Email" :error-message="form.errors.email">
        <Text
          id="email"
          v-model="form.email"
          type="email"
          required
          autofocus
          autocomplete="email"
          placeholder="Enter your email"
        />
      </InputGroup>
      <div class="mb-5 mt-6">
        <input
          type="submit"
          value="Email Password Reset Link"
          class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
        >
      </div>
    </form>
  </GuestLayout>
</template>
