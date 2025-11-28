<script setup lang="ts">
import AlbumCard from "@/components/albums/AlbumCard.vue";

defineProps<{
  latestRatings: ExtendedAlbum[],
}>();
</script>

<template>
  <div>
    <h1> User's Latest Ratings </h1>
    <hr class="w-24 mt-4 mb-6 border-zinc-800">

    <div class="grid grid-cols-4 gap-4" v-if="latestRatings.length > 0">
      <AlbumCard
        v-for="album in latestRatings" :key="album.id"
        :album="album" :show-artist="true" :show-user-rating="true" size="md"
      />
    </div>
    <div v-else>
      <p class="text-zinc-400 font-sans"> This user has not rated any albums yet. </p>
    </div>
  </div>
</template>
