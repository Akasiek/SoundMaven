<script setup lang="ts">
import Navigation from "@/components/Navigation.vue";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import Footer from "@/components/Footer.vue";
import { onMounted, ref } from "vue";
import QuickReviewModal from "@/components/QuickReviewModal.vue";
import { useAuthUser } from "@/composables/useAuthUser";

const user = useAuthUser();
const mainHeight = ref(0);

const getHeight = (selector: string) => (document.querySelector(selector) as HTMLElement)?.offsetHeight || 0;
const updateMainHeight = () => {
  const vh = window.innerHeight;
  mainHeight.value = vh - getHeight('#top-nav') - getHeight('footer');
};

onMounted(() => {
  window.addEventListener('resize', updateMainHeight);
  updateMainHeight();
});
</script>

<template>
  <PrimaryLayout>
    <QuickReviewModal v-if="user"/>
    <Navigation/>
    <main class="mt-18 px-4 sm:px-6 lg:px-8" :style="{ minHeight: `${mainHeight ?? 0}px` }">
      <slot/>
    </main>
    <Footer/>
  </PrimaryLayout>
</template>
