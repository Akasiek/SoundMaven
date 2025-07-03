<script setup lang="ts">

import AlbumHero from "@/components/albums/AlbumHero.vue";
import AlbumTrackList from "@/components/albums/AlbumTrackList.vue";
import AlbumUserReviewForm from "@/components/albums/AlbumUserReviewForm.vue";

defineProps<{ album: { data: ExtendedAlbum }, currentUserReview: null | { data: AlbumReview } }>();
</script>

<template>
  <div class="pt-12">
    <AlbumHero :album="album.data"/>
  </div>

  <section class="grid grid-cols-[2fr_1fr] gap-8 container mx-auto mt-8 mb-16">
    <aside id="left-panel">
      <AlbumUserReviewForm :album="album.data" :currentUserReview="currentUserReview?.data || null"/>
    </aside>

    <aside id="right-panel">
      <AlbumTrackList :album="album.data"/>
    </aside>
  </section>
</template>
