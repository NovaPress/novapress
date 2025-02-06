<script setup lang="ts">
import InputGroup from '@/Components/Admin/Forms/InputGroup.vue'
import Text from '@/Components/Admin/Forms/Text.vue'
import { onMounted, ref } from 'vue'

const newPassword = ref('')
const model = defineModel<string>({ required: true })

const passwordLength = 25

function generatePassword() {
  newPassword.value = ''
  const numbers = '0123456789'
  const upperCaseLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
  const lowerCaseLetters = 'abcdefghijklmnopqrstuvwxyz'
  const specialCharacters = '!\'^+%&/()=?_$#{[]}|;:>`<.*-@'

  let charsList = lowerCaseLetters
  charsList += numbers
  charsList += upperCaseLetters
  charsList += specialCharacters

  for (let i = 0; i < passwordLength; i++) {
    const charIndex = Math.round(Math.random() * charsList.length)
    newPassword.value = newPassword.value + charsList.charAt(charIndex)
  }
  model.value = newPassword.value
}

onMounted(() => {
  generatePassword()
})
</script>

<template>
  <div class="flex items-center justify-between space-x-8">
    <InputGroup label=" " class="w-full">
      <Text
        id="password"
        v-model="model"
        type="text"
        class="bg-white dark:bg-boxdark dark:text-white"
      />
    </InputGroup>
    <button
      class="w-60 cursor-pointer rounded-lg border border-primary bg-primary p-4 text-white
        transition hover:bg-opacity-90 mb-1.5"
      @click.prevent="generatePassword"
    >
      Generate Password
    </button>
  </div>
</template>
