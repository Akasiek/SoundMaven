<script setup lang="ts">
import { nextTick, watch } from "vue";
import { ChevronLeft, X } from "lucide-vue-next";
import { handleGlobalHotkeys, useQuickReviewChosenAlbumState, useQuickReviewModalOpenState } from "@/lib/quickReviewUtils";
import QuickReviewSearchInput from "@/components/quickReview/QuickReviewSearchInput.vue";
import QuickReviewChosenAlbumView from "@/components/quickReview/QuickReviewChosenAlbumView.vue";

const { isModalOpen, closeModal } = useQuickReviewModalOpenState();
const { chosenAlbum, clearChosenAlbum: clearChosenAlbumState } = useQuickReviewChosenAlbumState();

handleGlobalHotkeys();

// Focus the search input when the modal is opened
watch(isModalOpen, (val) => val && focusSearchInput());

const focusSearchInput = async (): Promise<void> => {
  await nextTick();
  document.getElementById('query')?.focus();
};

const clearChosenAlbum = () => {
  clearChosenAlbumState();
  focusSearchInput();
};
</script>

<template>
  <Transition
    enter-active-class="data-[state=open]:animate-in data-[state=open]:fade-in-0 duration-200"
    leave-active-class="data-[state=closed]:animate-out data-[state=closed]:fade-out-0 duration-200"
  >
    <div
      v-show="isModalOpen"
      :data-state="isModalOpen ? 'open' : 'closed'"
      class="fixed inset-0 z-50 bg-black/75 backdrop-blur-sm flex items-center justify-center"
      @click.self="closeModal"
    >
      <Transition
        enter-active-class="data-[state=open]:animate-in data-[state=open]:fade-in-0 data-[state=open]:zoom-in-95 duration-200"
        leave-active-class="data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95 duration-200"
      >
        <div
          v-show="isModalOpen"
          :data-state="isModalOpen ? 'open' : 'closed'"
          @click.stop
          class="relative min-h-36 min-w-2xl bg-zinc-850 rounded-lg shadow-lg border-2 border-zinc-800"
        >
          <div class="flex items-center bg-zinc-800">
            <button
              v-if="chosenAlbum"
              @click="clearChosenAlbum"
              class="flex items-center space-x-2 bg-zinc-800 h-full pl-6 pr-6 py-4 group border-r border-zinc-750 cursor-pointer"
            >
              <ChevronLeft :size="28"/>
            </button>
            <div
              class="flex w-full justify-between items-center py-4 border-b bg-zinc-800 rounded-t-lg"
              :class="chosenAlbum ? 'pl-6 pr-8' : 'px-8'"
            >
              <h3> Quickly Rate Album... </h3>
              <button
                class="text-white text-2xl z-50 cursor-pointer"
                @click="closeModal"
              >
                <X :size="24"/>
              </button>
            </div>
          </div>

          <QuickReviewSearchInput/>
          <QuickReviewChosenAlbumView/>
        </div>
      </Transition>
    </div>
  </Transition>
</template>
