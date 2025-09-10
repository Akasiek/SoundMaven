<script setup lang="ts">
import AlbumUserReviewForm from "@/components/albums/Show/AlbumUserReviewForm.vue";
import { useQuickReviewChosenAlbumState } from "@/lib/quickReviewUtils";

const { chosenAlbum } = useQuickReviewChosenAlbumState();

</script>

<template>
  <template v-if="chosenAlbum">
    <div class="p-8 space-y-6">
      <div class="flex items-center space-x-4">
        <img
          v-if="chosenAlbum.cover_image_preview"
          :src="chosenAlbum.cover_image_preview"
          :alt="chosenAlbum.title"
          class="w-24 h-24 object-cover rounded"
        />
        <div v-else class="w-24 h-24 bg-zinc-700 flex items-center justify-center rounded p-1 text-center">
          <span class="text-zinc-300 text-sm">No Image</span>
        </div>
        <div>
          <h3 class="text-2xl font-semibold text-white line-clamp-2">
            {{ chosenAlbum.title }}
          </h3>
          <p class="text-sm text-gray-400 font-sans">
            {{ chosenAlbum.artist.name }} | {{ new Date(chosenAlbum.release_date).getFullYear() }}
          </p>
        </div>
      </div>
    </div>
    <AlbumUserReviewForm
      :album="chosenAlbum"
      class="border-0 border-t-2 rounded-none"
      :is-in-modal="true"
      :current-user-review="chosenAlbum?.current_user_review || null"
    />
  </template>
</template>
