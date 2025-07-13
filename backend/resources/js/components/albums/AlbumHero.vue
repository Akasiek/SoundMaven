<script setup lang="ts">

import { Link } from "@inertiajs/vue3";

defineProps<{ album: ExtendedAlbum }>();
</script>

<template>
  <section class="container mx-auto rounded-lg flex p-10 gap-10 bg-zinc-850 border-2 border-zinc-800 shadow-xl">
    <div class="xl:h-120 xl:w-120 h-96 w-96 aspect-square object-center object-contain border-2 border-zinc-800 rounded-md overflow-hidden relative">
      <img v-if="album.cover_image_preview" :src="album.cover_image_preview" :alt="`${album.title} cover`"
           class="w-full h-full object-cover object-center">
      <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" class="w-full h-full object-cover object-center">
        <rect width="500" height="500" fill="#27262AFF"></rect>
        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="serif" font-size="26px" fill="#FAFAFAFF">
          Missing cover
        </text>
      </svg>
    </div>

    <div class="flex flex-col my-auto flex-1">

      <div class="flex my-auto gap-10 border-2 p-5 rounded-md border-zinc-700">
        <div>
          <h1 class="text-3xl font-bold">{{ album.title }}</h1>

          <p class="text-zinc-300 my-2">
            <Link v-if="album.artist" :href="route('artists.show', album.artist.slug)" class="hover:underline">{{ album.artist.name }}</Link>
            <span v-else>Unknown Artist</span>
          </p>

          <p class="text-sm text-zinc-500 font-sans">
            Released on {{ new Date(album.release_date).toLocaleDateString() }}
          </p>
        </div>

        <div>
          <hr class="border-zinc-700 border h-full">
        </div>

        <div class="flex items-center justify-center mb-4 mt-2 text-6xl mr-5 font-black leading-none">
          <div class="flex items-end">
            <span :class="`${album.rating_color}`">{{ album.average_rating }}</span>
            <span class="ml-1 text-zinc-500 text-lg">/100</span>
          </div>
        </div>
      </div>

      <div class="border-2 p-5 rounded-md border-zinc-700 mt-5" v-show="album.genres.length > 0">
        <h2 class="text-2xl font-bold mb-2">Genres</h2>
        <div class="flex items-center gap-4 font-sans text-zinc-300 text-sm font-semibold">
          <template v-for="(genre, index) in album.genres" :key="genre.id">
            <p>{{ genre.name }}</p>
            <hr v-if="index < album.genres.length - 1" class="border-zinc-700 border h-5">
          </template>
        </div>
      </div>

    </div>
  </section>
</template>
