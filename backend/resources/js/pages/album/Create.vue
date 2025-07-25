<script setup lang="ts">


import AlbumForm from "@/components/albums/Form/AlbumForm.vue";

defineProps<{
  types: string[],
}>();


</script>

<template>
  <AlbumForm :types="types" />
</template>
