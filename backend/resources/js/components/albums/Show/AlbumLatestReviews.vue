<script setup lang="ts">
import UserReviewCard from "@/components/reviews/UserReviewCard.vue";

defineProps<{
  latestReviews: ExtendedAlbumReview[]
}>();
</script>

<template>
  <div id="users-reviews" v-if="latestReviews.length > 0">
    <h2 class="mb-8">Latest reviews</h2>
    <div class="space-y-8">

      <div v-for="review in latestReviews" :key="review.id">
        <UserReviewCard
          :user="review.creator"
          :review="{ rating: review.rating, body: review.body, date: review.created_at }"
        />
      </div>

    </div>
  </div>
</template>
