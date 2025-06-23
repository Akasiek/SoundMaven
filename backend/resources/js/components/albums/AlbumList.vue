<script setup lang="ts">

import AlbumCard from "@/components/albums/AlbumCard.vue";

defineProps<{ albums: ExtendedAlbum[] | Album[], showArtist?: boolean, showDate?: boolean }>();
</script>

<template>
  <div class="grid xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12">
    <div v-for="album in albums" :key="album.id">
      <AlbumCard :album="album" :show-artist="showArtist || true" :show-date="showDate || false"/>
    </div>
  </div>
</template>
