<script setup lang="ts">
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { getRatingColor } from "@/composables/getRatingColor";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.locale('en');
dayjs.extend(relativeTime);

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

    <div class="grid gap-12" v-if="latestReviews.length > 0">
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

          <h3 v-if="album.user_review" :class="`text-${getRatingColor(album.user_review.rating)}-400`"
              class="flex items-end text-2xl leading-none font-black mr-2">
            {{ album.user_review.rating }} <span class="text-xs text-zinc-500 ml-0.5">/100</span>
          </h3>
        </div>

        <div v-if="album.user_review?.body" class="flex items-start gap-6 mt-4">
          <div class="border-l border-zinc-700 pl-4 ml-2 w-full">
            <p class="text-zinc-300 wrap-anywhere w-full pr-4"
               :class="((album.user_review.body && album.user_review.body.length <= 420) || openedReviews[index] || false) ? '' : 'line-clamp-3'">
              {{ album.user_review.body }}
            </p>
            <button class="text-green-400 hover:underline mt-2 cursor-pointer" @click="toggleReview(index)"
                    v-if="(album.user_review.body && album.user_review.body.length > 420)">
              {{ (openedReviews[index] || false) ? 'Show less' : 'Show more' }}
            </button>
          </div>
        </div>

        <div
          v-if="album.user_review?.date"
          class=" border-zinc-700 mt-6 ml-2"
          :title="dayjs(album.user_review.date).format('MMMM D, YYYY h:mm A')"
        >
          <p class="text-zinc-400 font-sans text-sm">
            Reviewed {{ dayjs(album.user_review.date).fromNow() }}
          </p>

        </div>

      </div>
    </div>
    <div v-else>
      <p class="text-zinc-400 font-sans"> This user has not written any reviews yet. </p>
    </div>
  </div>
</template>
