<script setup lang="ts">

import AlbumHero from "@/components/albums/AlbumHero.vue";
import AlbumTrackList from "@/components/albums/AlbumTrackList.vue";
import AlbumUserReviewForm from "@/components/albums/AlbumUserReviewForm.vue";

const props = defineProps<{ album: { data: ExtendedAlbum }, currentUserReview: null | AlbumReview }>();
</script>

<template>
  <div class="pt-12">
    <AlbumHero :album="props.album.data"/>
  </div>

  <section class="grid grid-cols-[2fr_1fr] gap-8 container mx-auto mt-8 mb-16">
    <aside id="left-panel">
      <AlbumUserReviewForm :album="props.album.data" :currentUserReview="props.currentUserReview"/>
    </aside>

    <aside id="right-panel">
      <AlbumTrackList :album="props.album.data"/>
    </aside>
  </section>
</template>
