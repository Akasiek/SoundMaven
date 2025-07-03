<script setup lang="ts">

import AlbumHero from "@/components/albums/AlbumHero.vue";
import AlbumTrackList from "@/components/albums/Show/AlbumTrackList.vue";
import AlbumUserReviewForm from "@/components/albums/Show/AlbumUserReviewForm.vue";
import AlbumLatestRatings from "@/components/albums/Show/AlbumLatestRatings.vue";

defineProps<{
  album: { data: ExtendedAlbum },
  currentUserReview: null | { data: AlbumReview },
  latestRatings: { data: ExtendedAlbumReview[] },
  latestReviews: { data: ExtendedAlbumReview[] }
}>();
</script>

<template>
  <div class="pt-12">
    <AlbumHero :album="album.data"/>
  </div>

  <section class="grid grid-cols-[2fr_1fr] gap-8 container mx-auto mt-8 mb-16">
    <aside id="left-panel" class="space-y-8">
      <AlbumUserReviewForm :album="album.data" :currentUserReview="currentUserReview?.data || null"/>
    </aside>

    <aside id="right-panel" class="space-y-8">
      <AlbumTrackList :album="album.data"/>
      <AlbumLatestRatings :latest-ratings="latestRatings.data"/>
    </aside>
  </section>
</template>
