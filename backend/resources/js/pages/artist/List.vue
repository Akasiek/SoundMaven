<script setup lang="ts">

import ArtistCard from "@/components/artists/ArtistCard.vue";

defineProps<{ artists: { data: Artist[] } }>();
</script>

<template>
  <main class="container mx-auto py-12">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-8 gap-y-8 md:gap-y-12">
      <template v-for="artist in artists.data" :key="artist.id">
        <ArtistCard :artist="artist"/>
      </template>
    </div>
  </main>
</template>
