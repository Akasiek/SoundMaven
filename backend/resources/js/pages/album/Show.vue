<script setup lang="ts">

import AlbumHero from "@/components/albums/AlbumHero.vue";
import AlbumTrackList from "@/components/albums/AlbumTrackList.vue";

const props = defineProps<{ album: { data: ExtendedAlbum } }>();
const album = props.album.data;
</script>

<template>
  <div class="pt-12">
    <AlbumHero :album="album"/>
  </div>

  <div class="grid grid-cols-[2fr_1fr] gap-12 container mx-auto mt-12">

    <section class="bg-zinc-850 border-2 border-zinc-800 shadow-xl rounded-lg p-6">

    </section>

    <AlbumTrackList :album="album"/>

  </div>
</template>
