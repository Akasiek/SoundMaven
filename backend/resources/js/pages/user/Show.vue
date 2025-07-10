<script setup lang="ts">

defineProps<{
  user: { data: User }
}>();
</script>

<template>
  {{ user.data.name }}
</template>

<style scoped>

</style>
