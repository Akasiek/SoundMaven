<script setup lang="ts">
import { X } from 'lucide-vue-next';
import { Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { Input } from "@/components/shadcn/ui/input";
import { handleGlobalHotkeys, useSearchSubmit } from "@/lib/navSearchUtils";

const queryResults = ref<{ album: ExtendedAlbum[], artist: ExtendedArtist[] } | null>(null);
const form = useForm<{ query: string; }>({ query: '' });

const handleSearchSubmit = useSearchSubmit(form, queryResults);

handleGlobalHotkeys();

// Submit the search when the query changes
watch(form, handleSearchSubmit);

watch(queryResults, (e) => console.log(e))

const clearSearch = () => {
  form.query = '';
  queryResults.value = null;
};
</script>

<template>
  <div>
    <form @submit.prevent="handleSearchSubmit">
      <div class="grid gap-2 relative">
        <Input
          id="nav-search-input"
          type="text"
          v-model="form.query"
          class="text-sm w-48 h-8"
          required
          placeholder="Search..."
        />
        <button
          class="absolute right-2 inset-y-0 flex items-center hover:text-zinc-300 transition-colors cursor-pointer"
          type="button"
          @click="clearSearch" v-if="form.query.length > 0"
        >
          <X :size="18"/>
        </button>
      </div>
    </form>

    <Teleport to="body">
      <Transition name="search-dropdown" appear>

        <div v-if="queryResults" class="container fixed mx-auto inset-x-0 top-18 z-20 flex justify-end font-serif">
          <div class="min-w-md max-h-[80dvh] bg-zinc-800 rounded-b-md shadow-xl border-2 border-t-0 border-zinc-700 mr-24 px-4 py-4 overflow-y-auto space-y-4">

            <div v-if="queryResults.artist.length > 0" class="space-y-2 border-2 border-zinc-700 rounded-md">

              <Link
                v-for="artist in queryResults.artist"
                :key="artist.id"
                class="flex items-center gap-5 py-3 px-4 bg-zinc-800 hover:bg-zinc-850 rounded-md transition-colors"
                :href="route('artists.show', { artist: artist.slug })"
                prefetch
                @click="clearSearch"
              >
                <div>
                  <img :src="artist.background_image_preview" alt="Artist Image" class="w-14 h-14 rounded-full object-cover object-center">
                </div>
                <h3>{{ artist.name }}</h3>
              </Link>
            </div>

            <div v-if="queryResults.album.length > 0" class="space-y-2 border-2 border-zinc-700 rounded-md">
              <Link
                v-for="album in queryResults.album"
                :key="album.id"
                class="flex items-center space-x-4 bg-zinc-800 hover:bg-zinc-850 transition-colors cursor-pointer px-4 py-4 rounded-md"
                :href="route('albums.show', { album: album.slug })"
                prefetch
                @click="clearSearch"
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
              </Link>
            </div>

          </div>
        </div>

      </Transition>
    </Teleport>
  </div>
</template>

<style scoped>
.search-dropdown-enter-active,
.search-dropdown-leave-active {
  transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}

.search-dropdown-enter-from {
  transform: translateY(-120px);
  opacity: 0;
}

.search-dropdown-leave-to {
  transform: translateY(-120px);
  opacity: 0;
}
</style>
