<script setup lang="ts">
import type Album from "~/interfaces/Album";

const { album } = defineProps<{
  album: Album;
}>();
</script>

<template>
  <section id="hero" class="flex gap-10">
    <NuxtImg v-if="album.cover_image" class="h-72" :src="album.cover_image" :alt="`${album.title} album cover`"/>

    <div class="font-serif my-auto">
      <h2 class="text-xl"> {{ album.artist.name }} </h2>
      <h1 class="text-3xl font-bold mb-2"> {{ album.title }} </h1>
      <h4 class="text-base text-zinc-400 mb-2">
        {{ album.release_date }} | {{ album.type }}
      </h4>
      <p v-if="album.genres">
        <template v-for="(genre, index) in album.genres" :key="genre.id">
            <span class="italic">
              {{ genre.name }}
            </span>
          <template v-if="index !== album.genres.length - 1"> • </template>
        </template>
      </p>
    </div>
  </section>
</template>

<style scoped>

</style>