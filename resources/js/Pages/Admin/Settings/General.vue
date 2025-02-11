<script setup lang="ts">
import type { DateFormat, Settings, TimeFormat } from '@/types'
import AdminHead from '@/Components/Admin/AdminHead.vue'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import Checkbox from '@/Components/Admin/Forms/Checkbox.vue'
// import FileUpload from '@/Components/Admin/Forms/FileUpload.vue'
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Radio from '@/Components/Admin/Forms/Radio.vue'
import Select from '@/Components/Admin/Forms/Select.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import { languages } from '@/Constants/languages'
import { roles } from '@/Constants/roles'
import { timezones } from '@/Constants/timezones'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps<{
  settings: Settings[]
  dateFormats: DateFormat
  timeFormats: TimeFormat
}>()

const form = useForm({
  site_title: props.settings[0].value,
  site_icon: props.settings[1].value,
  site_url: props.settings[2].value,
  admin_email: props.settings[3].value,
  registration: props.settings[4].value,
  default_role: props.settings[5].value,
  language: props.settings[6].value,
  timezone: props.settings[7].value,
  date_format: props.settings[8].value,
  time_format: props.settings[9].value,
})

const pageTitle = ref('General Settings')

function update() {
  form.put(route('admin.settings.general.update'))
}
</script>

<template>
  <AuthenticatedLayout>
    <AdminHead title="General Settings" />

    <!-- Breadcrumb Start -->
    <Breadcrumb :page-title="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-1 gap-9">
      <div class="flex flex-col gap-9">
        <form @submit.prevent="update">
          <InputGroup label="Site Title" :cols="2" :error-message="form.errors.site_title">
            <Text
              id="site_title"
              v-model="form.site_title"
              type="text"
              required
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>
          <InputGroup label="Site Icon" :cols="2" :error-message="form.errors.site_icon">
            <Text
              id="site_icon"
              v-model="form.site_icon"
              type="text"
              required
              class="bg-white dark:bg-boxdark dark:text-white"
            />
            <!-- <FileUpload /> -->
          </InputGroup>
          <InputGroup label="Site URL" :cols="2" :error-message="form.errors.site_url">
            <Text
              id="site_url"
              v-model="form.site_url"
              type="text"
              required
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>
          <InputGroup label="Administrator Email" :cols="2" :error-message="form.errors.admin_email">
            <Text
              id="admin_email"
              v-model="form.admin_email"
              type="email"
              required
              class="bg-white dark:bg-boxdark dark:text-white"
            />
          </InputGroup>
          <InputGroup label="Membership" :cols="2">
            <Checkbox v-model="form.registration" label="Anyone can register" />
          </InputGroup>
          <InputGroup label="Default Role" :cols="2" :error-message="form.errors.default_role">
            <Select v-model="form.default_role" :items="roles" />
          </InputGroup>
          <InputGroup label="Language" :cols="2" :error-message="form.errors.language">
            <Select v-model="form.language" :items="languages" />
          </InputGroup>
          <InputGroup label="Timezone" :cols="2" :error-message="form.errors.timezone">
            <select
              v-model="form.timezone"
              class="relative z-20 w-full appearance-none rounded border border-stroke bg-white py-3 px-5
                outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark
                dark:bg-form-input dark:focus:border-primary text-black dark:text-white"
              :items="timezones"
            >
              <optgroup v-for="(group, index) in timezones" :key="index" :label="group.group">
                <option
                  v-for="(item, key) in group.data"
                  :key="key"
                  :value="item.value"
                  :selected="item.selected"
                >
                  {{ item.name }}
                </option>
              </optgroup>
            </select>
          </InputGroup>
          <InputGroup label="Date Format" :cols="2" :error-message="form.errors.date_format">
            <Radio
              :id="dateFormats['j F Y'].value"
              v-model="form.date_format"
              :label="dateFormats['j F Y'].label"
              :value="dateFormats['j F Y'].value"
            />
            <Radio
              :id="dateFormats['Y-m-d'].value"
              v-model="form.date_format"
              :label="dateFormats['Y-m-d'].label"
              :value="dateFormats['Y-m-d'].value"
            />
            <Radio
              :id="dateFormats['m/d/Y'].value"
              v-model="form.date_format"
              :label="dateFormats['m/d/Y'].label"
              :value="dateFormats['m/d/Y'].value"
            />
            <Radio
              :id="dateFormats['d/m/Y'].value"
              v-model="form.date_format"
              :label="dateFormats['d/m/Y'].label"
              :value="dateFormats['d/m/Y'].value"
            />
          </InputGroup>
          <InputGroup label="Time Format" :cols="2" :error-message="form.errors.time_format">
            <Radio
              :id="timeFormats['12Hour'].value"
              v-model="form.time_format"
              :label="timeFormats['12Hour'].label"
              :value="timeFormats['12Hour'].value"
            />
            <Radio
              :id="timeFormats['24Hour'].value"
              v-model="form.time_format"
              :label="timeFormats['24Hour'].label"
              :value="timeFormats['24Hour'].value"
            />
          </InputGroup>
          <div class="mb-5 mt-6">
            <input
              type="submit"
              value="Save Changes"
              class="w-50 cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white
              transition hover:bg-opacity-90"
            >
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
