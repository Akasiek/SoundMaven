<script setup lang="ts">
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

defineProps<{ latestReviews: ExtendedAlbum[] }>();

const openedReviews = ref<boolean[]>([]);
const toggleReview = (index: number) => {
  openedReviews.value[index] = !openedReviews.value[index];
};
</script>

<template>
  <div>
    <h1> User's Latest Reviews </h1>
    <hr class="w-24 mt-4 mb-6 border-zinc-800">

    <div class="grid gap-12">
      <div
        v-for="(album, index) in latestReviews" :key="album.id"
        class="border-2 py-5 px-3 rounded-md bg-zinc-850 border-zinc-800 transition-colors duration-300 ease-in-out"
      >

        <div class="flex items-center justify-between">

        <div class="flex items-center gap-5">
          <div>
            <img v-if="album.cover_image" :src="album.cover_image" :alt="album.title"
                 class="min-w-18 w-18 h-18 rounded-sm object-cover object-center ml-2"/>
          </div>
          <div class="space-y-1">
            <h3 class="line-clamp-1">
              <Link prefetch :href="route('albums.show', album.slug)">
                {{ album.title }}
              </Link>
            </h3>
            <p class="text-zinc-400 font-sans">
              <Link prefetch :href="route('artists.show', album.artist.slug)">
                {{ album.artist.original_name }}
              </Link>
            </p>
          </div>
        </div>

          <h3 :class="`${album.user_rating_color}`" class="flex items-end text-2xl leading-none font-black mr-2">
            {{ album.user_rating }} <span class="text-xs text-zinc-500 ml-0.5">/100</span>
          </h3>
        </div>

        <div class="flex items-start gap-6 mt-4">
          <div class="border-l border-zinc-700 pl-4 ml-2 w-full">
            <p class="text-zinc-300 wrap-anywhere w-full pr-4"
               :class="((album.user_review && album.user_review.length <= 420) || openedReviews[index] || false) ? '' : 'line-clamp-3'">
              {{ album.user_review }}
            </p>
            <button class="text-green-400 hover:underline mt-2 cursor-pointer" @click="toggleReview(index)" v-if="(album.user_review && album.user_review.length > 420)">
              {{ (openedReviews[index] || false) ? 'Show less' : 'Show more' }}
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>
