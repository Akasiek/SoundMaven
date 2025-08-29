<script setup lang="ts">
import { nextTick, ref, watch } from "vue";
import { Star, X } from "lucide-vue-next";
import InputError from "@/components/inputs/InputError.vue";
import { Input } from "@/components/shadcn/ui/input";
import { useForm } from "@inertiajs/vue3";
import debounce from "lodash.debounce";
import axios from "axios";
import { useMagicKeys } from "@vueuse/core";

const KEYS = { SEARCH: 'q', ESCAPE: 'Escape' } as const;

const showModal = ref(false);
const queryResults = ref<{ data: { album: ExtendedAlbum[] } } | null>(null);
const form = useForm<{ query: string; }>({ query: '' });

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
}, 300);

const handleSearchResponse = (response: any): void => {
  queryResults.value = response.data;
  form.errors.query = undefined;
};

const handleSearchError = (err: any): void => {
  queryResults.value = null;
  form.errors.query = err.response.data.message;
};

watch(form, () => {
  submit();
});

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
          class="relative min-h-36 min-w-xl bg-zinc-850 rounded-lg shadow-lg border-2 border-zinc-800 data-[state=open]:animate-in
          data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95
          data-[state=open]:zoom-in-95 duration-200"
        >

          <div class="flex items-center justify-between px-8 py-4 border-b bg-zinc-800 rounded-t-lg">

            <h3>
              Quickly Rate Album...
            </h3>

            <button class=" text-white text-2xl z-50 cursor-pointer" @click="showModal = false">
              <X :size="24"/>
            </button>
          </div>

          <form @submit.prevent="submit" class="px-8 pt-6 pb-8">
            <div class="grid gap-2">
              <Input
                id="query"
                type="text"
                v-model="form.query"
                required
                class="text-xl h-14 px-4 py-2 font-sans"
                autofocus
              />

              <InputError :message="form.errors.query"/>
            </div>
          </form>

          <div v-if="queryResults && queryResults.data.album.length > 0"
               class="mx-8 mb-8 overflow-y-auto max-h-[70dvh] rounded-lg border-2 bg-zinc-800 p-4 space-y-4">
            <div v-for="album in queryResults.data.album" :key="album.id" class="flex items-center space-x-4">
              <template v-if="album.cover_image_preview">
                <img :src="album.cover_image_preview" :alt="album.title" class="w-16 h-16 object-cover rounded"/>
              </template>
              <template v-else>
                <div class="w-16 h-16 bg-zinc-700 flex items-center justify-center rounded p-1 text-center">
                  <span class="text-zinc-300 text-sm">No Image</span>
                </div>
              </template>
              <div>
                <h3 class="text-lg font-semibold text-white">{{ album.title }}</h3>
                <p class="text-sm text-gray-400">{{ new Date(album.release_date).getFullYear() }}</p>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </div>
  </Transition>
</template>
