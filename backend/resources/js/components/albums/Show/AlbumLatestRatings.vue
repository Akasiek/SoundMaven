<script setup lang="ts">

import { getRatingColor } from "@/composables/getRatingColor";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/shadcn/ui/avatar";
import { Link } from "@inertiajs/vue3";

defineProps<{ latestRatings: ExtendedAlbumReview[] }>();
</script>

<template>
  <div id="users-ratings" class="bg-zinc-850 border-2 border-zinc-800 shadow-xl rounded-lg p-6" v-if="latestRatings.length > 0">
    <h2 class="mb-4">Latest ratings</h2>
    <ul class="space-y-3">
      <li v-for="(rating, index) in latestRatings" :key="rating.id">
        <div class="flex items-center justify-between gap-5 border-zinc-700 pb-3 px-2" :class="index !== latestRatings.length - 1 ? 'border-b' : ''">

            <Link class="flex-1 flex items-center gap-3" :href="route('users.show', { user: rating.creator.slug })">
              <Avatar class="w-10 h-10">
                <AvatarImage src="https://github.com/unovue.png" :alt="`@${rating.creator.name}`"/>
                <AvatarFallback>CN</AvatarFallback>
              </Avatar>
              <p class="font-semibold">{{ rating.creator.name }} </p>
            </Link>

            <div class="flex items-end text-2xl leading-none font-bold" :class="`text-${getRatingColor(rating.rating)}-400`">
              {{ rating.rating }} <span class="text-sm text-zinc-500 ml-0.5">/100</span>
            </div>

        </div>
      </li>
    </ul>
  </div>
</template>
