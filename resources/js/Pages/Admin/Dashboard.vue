<script setup lang="ts">
import type { GlanceData } from '@/types'
import Breadcrumb from '@/Components/Admin/Breadcrumbs/Breadcrumb.vue'
import ActivityBox from '@/Components/Admin/Dashboard/ActivityBox.vue'
import AtGlanceBox from '@/Components/Admin/Dashboard/AtGlanceBox.vue'
import BoxGroup from '@/Components/Admin/Dashboard/BoxGroup.vue'
import DraftBox from '@/Components/Admin/Dashboard/DraftBox.vue'
import SiteHealthBox from '@/Components/Admin/Dashboard/SiteHealthBox.vue'
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps<{
  glanceData: GlanceData
}>()

const pageTitle = ref('Dashboard')
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />

    <!-- Breadcrumb Start -->
    <Breadcrumb :page-title="pageTitle" />
    <!-- Breadcrumb End -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 2xl:gap-7.5">
      <BoxGroup>
        <SiteHealthBox />
      </BoxGroup>

      <BoxGroup>
        <AtGlanceBox :model-value="glanceData" />
      </BoxGroup>

      <BoxGroup>
        <ActivityBox />
      </BoxGroup>

      <BoxGroup>
        <DraftBox />
      </BoxGroup>
    </div>
    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5" />
  </AuthenticatedLayout>
</template>
