<script setup lang="ts">
import type { SingleUser } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import PasswordGenerator from '@/Components/Admin/Forms/PasswordGenerator.vue'
import Select from '@/Components/Admin/Forms/Select.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head, router, useForm, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  user?: SingleUser
}>()

const authUser = usePage().props.auth.user.id
function submitButtonValue() {
  if (!props.user) {
    return 'Create User'
  }
  else if (authUser === props.user.data.id) {
    return 'Update Profile'
  }
  else {
    return 'Update User'
  }
}

function setFormValues() {
  if (props.user) {
    return useForm({
      name: props.user.data.name,
      email: props.user.data.email,
      role: props.user.data.role,
      password: '',
    })
  }
  else {
    return useForm({
      name: '',
      email: '',
      role: '',
      password: '',
    })
  }
}
const form = setFormValues()

const roles = [
  {
    name: 'Subscriber',
    value: 'subscriber',
    selected: true,
  },
  {
    name: 'Contributor',
    value: 'contributor',
    selected: false,
  },
  {
    name: 'Author',
    value: 'author',
    selected: false,
  },
  {
    name: 'Editor',
    value: 'editor',
    selected: false,
  },
  {
    name: 'Administrator',
    value: 'administrator',
    selected: false,
  },
]

const pageTitle = ref('Add New User')

function submit() {
  if (props.user) {
    form.put(route('admin.users.update', { user: props.user.data.id }), {
      onFinish: () => {
        form.reset('password')
      },
    })
  }
  else {
    form.post(route('admin.users.store'), {
      onFinish: () => {
        form.reset('password')
      },
    })
  }
}

function deleteIem() {
  router.delete(
    route('admin.users.destroy', { user: props.user!.data.id }),
  )
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Add New User" />

    <!-- Breadcrumb Start -->
    <Breadcrumb :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 px-4 sm:px-20 lg:px-80">
      <div class="flex flex-col gap-9">
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

          <InputGroup label="Email" :error-message="form.errors.email">
            <Text
              id="email"
              v-model="form.email"
              type="email"
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>

          <InputGroup label="Password" :error-message="form.errors.password">
            <PasswordGenerator v-model="form.password" />
          </InputGroup>

          <InputGroup label="Role" :error-message="form.errors.role">
            <Select v-model="form.role" :items="roles" />
          </InputGroup>

          <div class="mb-5 mt-6 flex items-center justify-around">
            <input
              type="submit"
              :value="submitButtonValue()"
              class="w-40 cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
            >
            <button
              v-if="props.user && authUser !== props.user!.data.id"
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
