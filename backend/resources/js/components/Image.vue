<script setup lang="ts">
import { ref } from "vue";
import { cn } from "@/lib/utils";

defineProps<{
  classes: string,
  src: string,
  alt: string,
  placeholder?: string
}>();

const loaded = ref(false);
</script>

<template>
  <div class="relative">
    <img
      v-if="placeholder"
      :src="placeholder"
      :alt="alt"
      :class="cn('absolute inset-0 transition-opacity duration-700 ease-in-out', classes)"
    />

    <img
      :src="src"
      :alt="alt"
      @load="loaded = true"
      :style="{ opacity: (!placeholder || loaded) ? 1 : 0 }"
      :class="cn('transition-opacity duration-800 ease-in-out relative')"
    />
  </div>
</template>
