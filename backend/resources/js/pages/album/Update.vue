<script setup lang="ts">
import AlbumForm from "@/components/albums/Form/AlbumForm.vue";

defineProps<{ types: string[], album: { data: ExtendedAlbum } }>();
</script>

<template>
  <AlbumForm :types="types" :album="album"/>
</template>
