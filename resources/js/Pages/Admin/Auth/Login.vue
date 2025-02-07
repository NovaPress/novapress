<script setup lang="ts">
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import GuestLayout from '@/Layouts/Admin/GuestLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

defineProps<{
  status?: string
}>()

const form = useForm({
  email: '',
  password: '',
  remember: false,
})

function submit() {
  form.post(route('admin.login.post'), {
    onFinish: () => {
      form.reset('password')
    },
  })
}
</script>

<template>
  <GuestLayout>
    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <InputGroup label="Email" :error-message="form.errors.email">
        <Text
          id="email"
          v-model="form.email"
          name="email"
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
          name="password"
          type="password"
          required
          autocomplete="current-password"
          placeholder="Enter your password"
        />
      </InputGroup>

      <div class="mb-5 mt-6">
        <button
          type="submit"
          class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
        >
          Log in
        </button>
      </div>

      <div class="mt-6 text-center">
        <Link :href="route('admin.password.request')" class="underline underline-offset-8 hover:text-primary">
          <p class="font-medium">
            Forgot your Password?
          </p>
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
