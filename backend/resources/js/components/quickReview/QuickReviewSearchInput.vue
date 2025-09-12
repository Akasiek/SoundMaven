<script setup lang="ts">

import { Input } from "@/components/shadcn/ui/input";
import InputError from "@/components/inputs/InputError.vue";
import { useQuickReviewChosenAlbumState, useSearchSubmit } from "@/lib/quickReviewUtils";
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { useEventBus } from "@vueuse/core";

const form = useForm<{ query: string; }>({ query: '' });
const queryResults = ref<{ album: ExtendedAlbum[] } | null>(null);
const { chosenAlbum, setChosenAlbum } = useQuickReviewChosenAlbumState();

const handleSearchSubmit = useSearchSubmit(form, queryResults);

const handleReloadSearch = () => {
  if (form.query) {
    handleSearchSubmit();
  }
};

// Re-submit the search when the query changes
watch(form, handleSearchSubmit);

// Watch for external events from other components to reload the search
useEventBus<string>('reloadSearch').on(handleReloadSearch);
</script>

<template>
  <template v-if="chosenAlbum === null">
    <form @submit.prevent="handleSearchSubmit" class="px-8 pt-6 pb-8">
      <div class="grid gap-2">
        <Input
          id="query"
          type="text"
          v-model="form.query"
          required
          class="text-xl h-14 px-4 py-2"
          autofocus
          placeholder="The Dark Side Of The Moon"
        />
        <InputError :message="form.errors.query"/>
      </div>
    </form>

    <div
      v-if="queryResults?.album.length"
      class="mx-8 mb-8 overflow-y-auto max-h-[70dvh] rounded-lg border-2 bg-zinc-800 space-y-2"
    >
      <div
        v-for="album in queryResults.album"
        :key="album.id"
        @click="setChosenAlbum(album)"
        class="flex items-center space-x-4 bg-zinc-800 hover:bg-zinc-750 transition-colors cursor-pointer px-4 py-4 rounded-md"
      >
        <img
          v-if="album.cover_image_preview"
          :src="album.cover_image_preview"
          :alt="album.title"
          class="w-16 h-16 object-cover rounded"
        />
        <div v-else class="w-16 h-16 bg-zinc-700 flex items-center justify-center rounded p-1 text-center">
          <span class="text-zinc-300 text-sm">No Image</span>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-white line-clamp-2">
            {{ album.title }}
          </h3>
          <p class="text-sm text-gray-400 font-sans">
            {{ album.artist.name }} | {{ new Date(album.release_date).getFullYear() }}
          </p>
        </div>
      </div>
    </div>
  </template>
</template>
