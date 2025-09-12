<script setup lang="ts">

defineProps<{
  user: User
}>();
</script>

<template>
  {{ user.name }}
</template>

<style scoped>

</style>
