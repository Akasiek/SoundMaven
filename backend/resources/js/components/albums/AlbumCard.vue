<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { getNonBreakingSpaces } from "@/composables/getNonBreakingSpaces";

defineProps<{
  album: ExtendedAlbum | Album;
  showArtist?: boolean;
  showDate?: boolean;
}>();
</script>

<template>
  <Link :href="route('albums.show', album.slug)" class="block group transition duration-300 ease-in-out">
    <div
      class="w-full aspect-square overflow-hidden relative transition duration-300 ease-in-out border-2 rounded-md border-zinc-800 group-hover:border-zinc-600">
      <img v-if="album.cover_image" :src="album.cover_image" :alt="album.title" class="w-full h-full object-cover object-center"/>
      <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300">
        <rect width="300" height="300" fill="#27262AFF"></rect>
        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="serif" font-size="26px" fill="#FAFAFAFF">
          Missing cover
        </text>
      </svg>
    </div>

    <div
      class="grid grid-cols-[1fr_auto] gap-x-2.5 px-3 mt-4 py-3 border-2 rounded-md border-zinc-800 group-hover:border-zinc-600 transition duration-300 ease-in-out">
      <div class="space-y-1 w-full">
        <h2 class="sm:text-lg font-bold line-clamp-2" :title="album.title">
          {{ album.title }}
        </h2>

        <Link
          v-if="showArtist && 'artist' in album"
          :href="route('artists.show', (album as ExtendedAlbum).artist.slug)"
          class="hover:underline line-clamp-2"
        >
          <h3 class="text-sm sm:text-base">{{ getNonBreakingSpaces((album as ExtendedAlbum).artist.original_name) }}</h3>
        </Link>
        <p class="text-xs sm:text-sm font-sans text-zinc-400" v-show="showDate || false">
          {{ new Date(album.release_date).toLocaleDateString() }}
        </p>

      </div>

      <div :class="`pr-2 py-2.5 text-xl sm:text-2xl md:text-[28px] font-black flex justify-center leading-none ${album.rating_color}`">
        {{ album.average_rating }}
      </div>
    </div>
  </Link>
</template>
