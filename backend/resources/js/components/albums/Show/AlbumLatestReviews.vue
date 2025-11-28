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
              <AvatarImage v-if="review.creator.avatar_preview" :src="review.creator.avatar_preview" :alt="`${review.creator.name} profile picture`"/>
              <AvatarFallback v-else>CN</AvatarFallback>
            </Avatar>
            <p class="font-semibold">{{ review.creator.name }}</p>
          </Link>

          <div class="flex items-end text-2xl leading-none font-black" :class="`text-${getRatingColor(review.rating)}-400`">
            {{ review.rating }} <span class="text-xs text-zinc-500 ml-0.5">/100</span>
          </div>
        </div>

        <p
          class="border-l border-zinc-700 pl-4 ml-2 text-zinc-300 mt-2 prose max-w-full wrap-anywhere"
          :class="(review.body.length <= 420 || openedReviews[index] || false) ? '' : 'line-clamp-3'"
        >
          {{ review.body }}
        </p>
        <button class="text-green-400 hover:underline mt-2 cursor-pointer" @click="toggleReview(index)" v-if="review.body.length > 420">
          {{ (openedReviews[index] || false) ? 'Show less' : 'Show more' }}
        </button>

      </div>

    </div>
  </div>
</template>
