<script setup lang="ts">
import AlbumHero from "@/components/albums/AlbumHero.vue";
import AlbumTrackList from "@/components/albums/Show/AlbumTrackList.vue";
import AlbumUserReviewForm from "@/components/albums/Show/AlbumUserReviewForm.vue";
import AlbumLatestRatings from "@/components/albums/Show/AlbumLatestRatings.vue";
import AlbumLatestReviews from "@/components/albums/Show/AlbumLatestReviews.vue";

defineProps<{
  album: ExtendedAlbum,
  currentUserReview: null | AlbumReview,
  latestRatings: ExtendedAlbumReview[],
  latestReviews: ExtendedAlbumReview[]
}>();
</script>

<template>
  <div class="pt-12">
    <AlbumHero :album="album"/>
  </div>

  <section class="grid grid-cols-[2fr_1fr] gap-8 container mx-auto mt-8 mb-16">
    <aside id="left-panel" class="space-y-8">
      <AlbumUserReviewForm :album="album" :currentUserReview="currentUserReview || null"/>
      <AlbumLatestReviews :latest-reviews="latestReviews"/>
    </aside>

    <aside id="right-panel" class="space-y-8">
      <AlbumTrackList :album="album"/>
      <AlbumLatestRatings :latest-ratings="latestRatings"/>
    </aside>
  </section>
</template>
