<script setup lang="ts">
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import GuestLayout from '@/Layouts/Admin/GuestLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{
  email: string
  token: string
}>()

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

function submit() {
  form.post(route('admin.password.update'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation')
    },
  })
}
</script>

<template>
  <GuestLayout>
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

      <InputGroup label="Password" :error-message="form.errors.password">
        <Text
          id="password"
          v-model="form.password"
          type="password"
          required
          autocomplete="new-password"
          placeholder="Enter your password"
        />
      </InputGroup>

      <InputGroup label="Confirm Password" :error-message="form.errors.password_confirmation">
        <Text
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          required
          autocomplete="new-password"
          placeholder="Confirm your password"
        />
      </InputGroup>

      <div class="mb-5 mt-6">
        <input
          type="submit"
          value="Reset Password"
          class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
        >
      </div>
    </form>
  </GuestLayout>
</template>
