<script setup lang="ts">
import { Star } from "lucide-vue-next";
import QuickReviewModal from "@/components/quickReview/QuickReviewModal.vue";
import { useQuickReviewModalOpenState } from "@/lib/quickReviewUtils";

const { openModal } = useQuickReviewModalOpenState();
</script>

<template>
  <button
    @click="openModal"
    class="fixed bottom-12 right-16 w-14 h-14 p-3 bg-green-500 z-50 flex items-center justify-center rounded-full shadow-[0_0_0] hover:shadow-[0_0_1rem] transition-all duration-300 ease-in-out shadow-green-500/75 cursor-pointer"
  >
    <Star class="h-full w-full"/>
  </button>
  <QuickReviewModal/>
</template>
