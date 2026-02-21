<script setup lang="ts">

import UserReviewCard from "@/components/reviews/UserReviewCard.vue";


defineProps<{ latestReviews: ExtendedAlbum[] }>();

</script>

<template>
  <div>
    <h1> User's Latest Reviews </h1>
    <hr class="w-24 mt-4 mb-6 border-zinc-800">

    <div class="grid gap-12" v-if="latestReviews.length > 0">
      <template v-for="album in latestReviews" :key="album.id">
        <UserReviewCard v-if="album.user_review" :album="album" :review="album.user_review"/>
      </template>
    </div>

    <div v-else>
      <p class="text-zinc-400 font-sans"> This user has not written any reviews yet. </p>
    </div>
  </div>
</template>
