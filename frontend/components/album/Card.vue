<script setup lang="ts">
import type Album from "~/interfaces/Album";

const { album } = defineProps<{
  album: Album;
}>();
</script>

<template>
  <NuxtLink :to="`/albums/${album.slug}`">
    <div class="font-serif">
      <NuxtImg
          v-if="album.cover_image" class="h-full aspect-square" :src="album.cover_image"
          :alt="`${album.title} album cover`"/>

      <p class="text-lg font-bold"> {{ album.title }} </p>
      <p><i> {{ album.artist.name }} </i></p>
      <p>
        <i v-if="album.genres" class="text-sm text-zinc-400">
          <template v-for="(genre, index) in album.genres" :key="genre.id">
            <span class="italic">
              {{ genre.name }}
            </span>
            <template v-if="index !== album.genres.length - 1"> •&nbsp;</template>
          </template>
        </i>
      </p>
    </div>
  </NuxtLink>
</template>

<style scoped>

</style>