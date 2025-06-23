<script setup lang="ts">

import AlbumHero from "@/components/albums/AlbumHero.vue";

const props = defineProps<{ album: { data: ExtendedAlbum } }>();
const album = props.album.data;
</script>

<template>
  <div class="pt-12">
    <AlbumHero :album="album"/>
  </div>
</template>
