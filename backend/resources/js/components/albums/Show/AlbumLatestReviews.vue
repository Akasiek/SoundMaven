<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from "@/components/shadcn/ui/avatar";
import { getRatingColor } from "@/composables/getRatingColor";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

defineProps<{
  latestReviews: ExtendedAlbumReview[]
}>();

const openedReviews = ref<boolean[]>([]);
const toggleReview = (index: number) => {
  openedReviews.value[index] = !openedReviews.value[index];
};
</script>

<template>
  <div id="users-reviews" class="bg-zinc-850 border-2 border-zinc-800 shadow-xl rounded-lg p-6" v-if="latestReviews.length > 0">
    <h2 class="mb-8">Latest reviews</h2>
    <div class="space-y-8">

      <div v-for="(review, index) in latestReviews" :key="review.id" class="border-zinc-700 px-2"
           :class="index !== latestReviews.length - 1 ? 'border-b pb-8' : 'pb-4'">

        <div class="flex justify-between items-center gap-5">
          <Link class="flex items-center gap-5" :href="route('users.show', { user: review.creator.slug })">
            <Avatar class="w-10 h-10">
              <AvatarImage src="https://github.com/unovue.png" :alt="`@${review.creator.name}`"/>
              <AvatarFallback>CN</AvatarFallback>
            </Avatar>
            <p class="font-semibold">{{ review.creator.name }}</p>
          </Link>

          <div class="flex items-end text-2xl leading-none font-bold" :class="`text-${getRatingColor(review.rating)}-400`">
            {{ review.rating }} <span class="text-sm text-zinc-500 ml-0.5">/100</span>
          </div>
        </div>

        <p class="text-zinc-300 mt-2 prose max-w-full " :class="(review.body.length <= 420 || openedReviews[index] || false) ? '' : 'line-clamp-3'">
          {{ review.body }}
        </p>
        <button class="text-green-400 hover:underline mt-2 cursor-pointer" @click="toggleReview(index)" v-if="review.body.length > 420">
          {{ (openedReviews[index] || false) ? 'Show less' : 'Show more' }}
        </button>

      </div>

    </div>
  </div>
</template>
