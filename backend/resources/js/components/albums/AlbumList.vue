<script setup lang="ts">

import AlbumCard from "@/components/albums/AlbumCard.vue";

defineProps<{ albums: ExtendedAlbum[], showArtist: boolean }>();
</script>

<template>
  <div class="grid xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12">
    <div v-for="album in albums" :key="album.id">
      <AlbumCard :album="album" :show-artist="showArtist"/>
    </div>
  </div>
</template>

<style scoped>

</style>
