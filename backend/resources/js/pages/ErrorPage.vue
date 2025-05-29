<script setup lang="ts">
import { computed } from 'vue'
import Gandalf from '@/assets/gandalf.svg';

const props = defineProps<{ status: 503|500|404|403 }>();

const title = computed(() => {
  return {
    503: 'Service Unavailable',
    500: 'Server Error',
    404: 'Page Not Found',
    403: 'Forbidden',
  }[props.status]
})

const description = computed(() => {
  return {
    503: 'Sorry, we are doing some maintenance. Please check back soon.',
    500: 'Whoops, something went wrong on our servers.',
    404: 'Are you lost, little one?',
    403: 'You shall not pass!'
  }[props.status]
})
</script>

<template>
  <div class="min-h-[calc(100vh-4.5rem)] mx-auto flex flex-col items-center justify-center text-center space-y-4" :class="props.status === 403 ? 'pb-12' : ''">
    <img v-if="props.status === 403" :src="Gandalf" alt="Gandalf" class="w-32 h-32 fill-zinc-50" />
    <h1 class="text-6xl font-sans font-black z-10">{{ title }}</h1>
    <div class="text-zinc-500 text-lg z-10">{{ description }}</div>
  </div>
</template>
