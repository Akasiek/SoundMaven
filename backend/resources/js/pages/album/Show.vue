<script setup lang="ts">

import AlbumHero from "@/components/albums/AlbumHero.vue";
import AlbumTrackList from "@/components/albums/AlbumTrackList.vue";
import AlbumUserReviewForm from "@/components/albums/AlbumUserReviewForm.vue";

const props = defineProps<{ album: { data: ExtendedAlbum } }>();
const album = props.album.data;
</script>

<template>
  <div class="pt-12">
    <AlbumHero :album="album"/>
  </div>

  <section class="grid grid-cols-[2fr_1fr] gap-12 container mx-auto mt-12">
    <aside id="left-panel">
      <AlbumUserReviewForm :album="album"/>
    </aside>

    <aside id="right-panel">
      <AlbumTrackList :album="album"/>
    </aside>
  </section>
</template>
