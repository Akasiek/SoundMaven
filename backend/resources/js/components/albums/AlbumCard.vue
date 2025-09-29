<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { getNonBreakingSpaces } from "@/composables/getNonBreakingSpaces";

const { showUserRating = false, size = 'lg' } = defineProps<{
  album: ExtendedAlbum | Album;
  showArtist?: boolean;
  showDate?: boolean;
  showUserRating?: boolean;
  size?: string
}>();

const styles = {
  lg: {
    albumTitle: "!text-base sm:!text-lg",
    artistName: "!text-sm sm:!text-base",
    rating: "text-xl sm:text-2xl md:text-[28px] pr-2"
  },
  md: {
    albumTitle: "text-sm sm:!text-base",
    artistName: "!text-xs sm:!text-sm",
    rating: "text-lg sm:text-xl md:text-2xl pr-0.5"
  },
  sm: {
    albumTitle: "!text-xs sm:!text-sm",
    artistName: "!text-xs",
    rating: "text-base sm:text-lg md:text-xl pr-0"
  }
}

const getStyledSize = (size: string, element: string) => {
  return styles[size as keyof typeof styles][element as keyof typeof styles['lg']]
}
</script>

<template>
  <Link prefetch :href="route('albums.show', album.slug)" class="block group transition-colors duration-300 ease-in-out" :title="album.title">
    <div
      class="w-full aspect-square overflow-hidden relative transition-colors duration-300 ease-in-out border-2 rounded-md border-zinc-800 group-hover:border-zinc-600">
      <img v-if="album.cover_image" :src="album.cover_image" :alt="album.title" class="w-full h-full object-cover object-center"/>
      <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300">
        <rect width="300" height="300" fill="#27262AFF"></rect>
        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="serif" font-size="26px" fill="#FAFAFAFF">
          Missing cover
        </text>
      </svg>
    </div>

    <div
      class="grid grid-cols-[1fr_auto] gap-x-2.5 px-3 mt-4 py-3 border-2 rounded-md border-zinc-800 group-hover:border-zinc-600 transition-colors duration-300 ease-in-out">
      <div class="space-y-1 w-full">
        <h2 class="font-bold line-clamp-2" :class="getStyledSize(size, 'albumTitle')">
          {{ album.title }}
        </h2>

        <Link
          prefetch
          v-if="showArtist && 'artist' in album"
          :href="route('artists.show', (album as ExtendedAlbum).artist.slug)"
          class="hover:underline line-clamp-2"
        >
          <h3 class="font-sans font-normal text-zinc-300" :class="getStyledSize(size, 'artistName')">
            {{ getNonBreakingSpaces((album as ExtendedAlbum).artist.original_name) }}
          </h3>
        </Link>
        <p class="text-xs sm:text-sm font-sans text-zinc-400" v-show="showDate || false">
          {{ new Date(album.release_date).toLocaleDateString() }}
        </p>

      </div>

      <div class="py-2.5  font-black flex justify-center leading-none" :class="getStyledSize(size, 'rating')">
        <span v-if="showUserRating" :class="`${album.user_rating_color}`">
          {{ album.user_rating }}
        </span>
        <span v-else :class="`${album.rating_color}`">
          {{ album.average_rating }}
        </span>
      </div>
    </div>
  </Link>
</template>
