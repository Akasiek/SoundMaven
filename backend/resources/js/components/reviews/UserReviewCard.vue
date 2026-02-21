<script setup lang="ts">

import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { getRatingColor } from "@/composables/getRatingColor";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/shadcn/ui/avatar";

dayjs.locale('en');
dayjs.extend(relativeTime);

defineProps<{
  album?: ExtendedAlbum,
  user?: User,

  review: { rating: number, body: string, date: string }
}>();

const isReviewOpened = ref(false);
const toggleReview = () => {
  isReviewOpened.value = !isReviewOpened.value;
};
</script>

<template>
  <div
    class="border-2 py-5 px-3 rounded-md bg-zinc-850 border-zinc-800 transition-colors duration-300 ease-in-out"
  >

    <div class="flex items-center justify-between">

      <!-- Album info -->
      <div class="flex items-center gap-5" v-if="album">
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

      <!-- User info -->
      <div v-else-if="user" class="flex justify-between items-center gap-5">
        <Link class="flex items-center gap-5" :href="route('users.show', { user: user.slug })">
          <Avatar class="w-10 h-10">
            <AvatarImage v-if="user.avatar_preview" :src="user.avatar_preview" :alt="`${user.name} profile picture`"/>
            <AvatarFallback v-else>CN</AvatarFallback>
          </Avatar>
          <p class="font-semibold">{{ user.name }}</p>
        </Link>
      </div>

      <h3 v-if="review.rating" :class="`text-${getRatingColor(review.rating)}-400`"
          class="flex items-end text-2xl leading-none font-black mr-2">
        {{ review.rating }} <span class="text-xs text-zinc-500 ml-0.5">/100</span>
      </h3>
    </div>

    <div v-if="review.body" class="flex items-start gap-6 mt-4">
      <div class="border-l border-zinc-700 pl-4 ml-2 w-full">
        <p class="text-zinc-300 wrap-anywhere w-full pr-4"
           :class="((review.body && review.body.length <= 420) || isReviewOpened || false) ? '' : 'line-clamp-3'">
          {{ review.body }}
        </p>
        <button class="text-green-400 hover:underline mt-2 cursor-pointer" @click="toggleReview()"
                v-if="(review.body && review.body.length > 420)">
          {{ (isReviewOpened || false) ? 'Show less' : 'Show more' }}
        </button>
      </div>
    </div>

    <div
      class=" border-zinc-700 mt-6 ml-2"
      :title="dayjs(review.date).format('MMMM D, YYYY h:mm A')"
    >
      <p class="text-zinc-400 font-sans text-sm">
        Reviewed {{ dayjs(review.date).fromNow() }}
      </p>
    </div>
  </div>
</template>
