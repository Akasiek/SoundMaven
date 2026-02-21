<script setup lang="ts">

import Image from "@/components/Image.vue";
import { Link } from "@inertiajs/vue3";

defineProps<{ user: UserWithStats }>();
</script>

<template>
  <Link
    prefetch
    v-if="user.favorite_artist"
    :href="route('artists.show', user.favorite_artist.slug)"
  >
    <div class="border-2 border-zinc-800 rounded-md overflow-hidden relative h-48">

      <!-- Shadow overlay -->
      <div class="absolute inset-0 bg-linear-to-t from-zinc-900/90 to-transparent z-10"></div>

      <div class="w-full h-full">
        <Image :src="user.favorite_artist.background_image" :alt="`${user.favorite_artist.name} background`"
               :placeholder="user.favorite_artist.background_image_placeholder"/>
      </div>

      <div class="absolute bottom-0 left-0 p-4 z-20">
        <p class="text-sm text-zinc-400 font-sans">
          Favorite Artist
        </p>
        <h3 class="text-lg font-semibold">
          {{ user.favorite_artist.name }}
        </h3>
      </div>
    </div>
  </Link>
</template>
