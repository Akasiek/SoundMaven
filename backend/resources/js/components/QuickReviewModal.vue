<script setup lang="ts">
import { nextTick, ref, watch } from "vue";
import { ChevronLeft, Star, X } from "lucide-vue-next";
import InputError from "@/components/inputs/InputError.vue";
import { Input } from "@/components/shadcn/ui/input";
import { useForm } from "@inertiajs/vue3";
import debounce from "lodash.debounce";
import axios from "axios";
import { useMagicKeys } from "@vueuse/core";
import AlbumUserReviewForm from "@/components/albums/Show/AlbumUserReviewForm.vue";

const KEYS = { SEARCH: 'q', ESCAPE: 'Escape' } as const;

const showModal = ref(false);
const queryResults = ref<{ data: { album: ExtendedAlbum[] } } | null>(null);
const form = useForm<{ query: string; }>({ query: '' });
const chosenAlbum = ref<ExtendedAlbum | null>(null);

const preventDefaultAndStopPropagation = (e: KeyboardEvent): void => {
  e.preventDefault();
  e.stopPropagation();
};

const resetSearchForm = (): void => {
  form.query = '';
};

const handleSearchKey = (e: KeyboardEvent) => {
  if (!showModal.value) {
    preventDefaultAndStopPropagation(e);
    showModal.value = true;
    resetSearchForm();
  }
};

const handleEscapeKey = (e: KeyboardEvent) => {
  if (showModal.value) {
    preventDefaultAndStopPropagation(e);
    showModal.value = false;
    resetSearchForm();
  }
};

useMagicKeys({
  passive: false,
  onEventFired(e) {
    if (e.key === KEYS.SEARCH) {
      handleSearchKey(e);
    } else if (e.key === KEYS.ESCAPE) {
      handleEscapeKey(e);
    }
  }
});

const focusSearchInput = async (): Promise<void> => {
  await nextTick();
  const input = document.getElementById('query') as HTMLInputElement | null;
  if (input) {
    input.focus();
  }
};

watch(showModal, () => {
  if (showModal.value) {
    focusSearchInput();
  }
});

const submit = () => {
  if (form.query) {
    debouncedSearch();
  } else {
    queryResults.value = null;
  }
};

const debouncedSearch = debounce(() => {
  axios.get(route('search', { 'type': 'album', 'query': form.query }))
    .then(handleSearchResponse)
    .catch(handleSearchError);
}, 100);

const handleSearchResponse = (response: any): void => {
  queryResults.value = response.data;
  form.errors.query = undefined;

  // Search the chosen album in new results and update chosenAlbum
  if (queryResults.value && chosenAlbum) {
    const updatedChosenAlbum = queryResults.value.data.album.find(a => a.id === chosenAlbum.value?.id);
    if (updatedChosenAlbum) {
      chosenAlbum.value = updatedChosenAlbum;
    }
  }
};

const handleSearchError = (err: any): void => {
  queryResults.value = null;
  form.errors.query = err.response.data.message;
};

watch(form, () => {
  submit();
});

const chooseAlbum = (album: ExtendedAlbum) => {
  chosenAlbum.value = album;
}

const clearChosenAlbum = () => {
  chosenAlbum.value = null;
  focusSearchInput();
}

const reloadSearch = async () => {
  if (form.query) {
    console.log('reloading search');
    submit();
  }
}
</script>

<template>
  <button
    @click="showModal = !showModal"
    class="
      fixed bottom-12 right-16 w-14 h-14 p-3 bg-green-500 z-50 flex items-center justify-center rounded-full shadow-[0_0_0] hover:shadow-[0_0_1rem]
      transition-all duration-300 ease-in-out shadow-green-500/75 cursor-pointer
    ">
    <Star class="h-full w-full"/>
  </button>
  <Transition
    enter-active-class="data-[state=open]:animate-in data-[state=open]:fade-in-0 duration-200"
    leave-active-class="data-[state=closed]:animate-out data-[state=closed]:fade-out-0 duration-200"
    enter-from-class="data-[state=closed]:fade-out-0"
    enter-to-class="data-[state=open]:fade-in-0"
    leave-from-class="data-[state=open]:fade-in-0"
    leave-to-class="data-[state=closed]:fade-out-0"
  >
    <div
      v-show="showModal"
      :data-state="showModal ? 'open' : 'closed'"
      class="fixed inset-0 z-50 bg-black/75 backdrop-blur-sm data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 duration-200 flex items-center justify-center"
      @click.self="showModal = false"
    >
      <Transition
        enter-active-class="data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95 duration-200"
        leave-active-class="data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95 duration-200"
        enter-from-class="data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95"
        enter-to-class="data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95"
        leave-from-class="data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95"
        leave-to-class="data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95"
      >
        <div
          v-show="showModal"
          :data-state="showModal ? 'open' : 'closed'"
          @click.stop
          class="relative min-h-36 min-w-2xl bg-zinc-850 rounded-lg shadow-lg border-2 border-zinc-800 data-[state=open]:animate-in
          data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95
          data-[state=open]:zoom-in-95 duration-200"
        >

          <div class="flex items-center bg-zinc-800">
            <button
              v-if="chosenAlbum" @click="clearChosenAlbum"
              class="flex items-center space-x-2 bg-zinc-800  h-full pl-6 pr-6 py-4 group border-r border-zinc-750 cursor-pointer"
            >
              <ChevronLeft :size="28"/>
            </button>
            <div class="flex w-full justify-between items-center py-4 border-b bg-zinc-800 rounded-t-lg" :class="chosenAlbum ? 'pl-6 pr-8' : 'px-8'">
              <h3> Quickly Rate Album... </h3>

              <button class=" text-white text-2xl z-50 cursor-pointer" @click="showModal = false">
                <X :size="24"/>
              </button>
            </div>
          </div>

          <template v-if="!chosenAlbum">

            <form @submit.prevent="submit" class="px-8 pt-6 pb-8">
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
              v-if="queryResults && queryResults.data.album.length > 0"
              class="mx-8 mb-8 overflow-y-auto max-h-[70dvh] rounded-lg border-2 bg-zinc-800"
            >
              <div v-for="album in queryResults.data.album" :key="album.id" @click="chooseAlbum(album)"
                   class="flex items-center space-x-4 bg-zinc-800 hover:bg-zinc-750 transition-colors cursor-pointer px-4 py-4 rounded-md">
                <template v-if="album.cover_image_preview">
                  <img :src="album.cover_image_preview" :alt="album.title" class="w-16 h-16 object-cover rounded"/>
                </template>
                <template v-else>
                  <div class="w-16 h-16 bg-zinc-700 flex items-center justify-center rounded p-1 text-center">
                    <span class="text-zinc-300 text-sm">No Image</span>
                  </div>
                </template>
                <div>
                  <h3 class="text-lg font-semibold text-white line-clamp-2">{{ album.title }}</h3>
                  <p class="text-sm text-gray-400 font-sans">{{ album.artist.name }} | {{ new Date(album.release_date).getFullYear() }}</p>
                </div>
              </div>
            </div>
          </template>
          <template v-else>

            <div class="p-8 space-y-6">
              <div class="flex items-center space-x-4">
                <template v-if="chosenAlbum.cover_image_preview">
                  <img :src="chosenAlbum.cover_image_preview" :alt="chosenAlbum.title" class="w-24 h-24 object-cover rounded"/>
                </template>
                <template v-else>
                  <div class="w-24 h-24 bg-zinc-700 flex items-center justify-center rounded p-1 text-center">
                    <span class="text-zinc-300 text-sm">No Image</span>
                  </div>
                </template>
                <div>
                  <h3 class="text-2xl font-semibold text-white line-clamp-2">{{ chosenAlbum.title }}</h3>
                  <p class="text-sm text-gray-400 font-sans">
                    {{ chosenAlbum.artist.name }} | {{ new Date(chosenAlbum.release_date).getFullYear() }}
                  </p>
                </div>
              </div>
            </div>

            <AlbumUserReviewForm
              :album="chosenAlbum" class="border-0 border-t-2 rounded-none" :is-in-modal="true"
              :current-user-review="chosenAlbum?.current_user_review || null"
              @reload-search="reloadSearch"
            />

          </template>

        </div>
      </Transition>
    </div>
  </Transition>
</template>
