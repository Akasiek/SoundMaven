<script setup lang="ts">
import { getNonBreakingSpacesAsRef } from "@/composables/getNonBreakingSpaces";
import Image from "@/components/Image.vue";

const { artist } = defineProps<{ artist: Artist }>()

const name = getNonBreakingSpacesAsRef(artist.original_name);
</script>

<template>
  <section class="w-full relative scale-105">
    <div id="artist-gradient-bottom" class="absolute inset-x-0 -bottom-0.5 h-1/2 z-10"></div>
    <div id="artist-gradient-right" class="absolute inset-y-0 -right-0.5 w-3/5 z-10"></div>
    <div id="artist-gradient-left" class="absolute inset-y-0 -left-0.5 w-3/5 z-10"></div>
    <div id="artist-radial-gradient" class="absolute inset-0 z-10"></div>
    <div class="aspect-video w-full z-0">
      <Image :src="artist.background_image" :alt="`${artist.name} background`" :placeholder="artist.background_image_placeholder"
             classes="w-full h-full object-center object-cover"/>
    </div>

    <div class="absolute inset-x-0 bottom-10 mx-16 z-10">
      <h1 class="text-6xl font-black text-white mb-12 max-w-3xl">
        {{ name }}
      </h1>
    </div>
  </section>
</template>

<style scoped>
#artist-radial-gradient {
  background: radial-gradient(
    circle at 50% -25%,
    hsla(240, 5.88%, 10%, 0) 0%,
    hsla(240, 5.88%, 10%, 0) 16.7%,
    hsla(240, 5.88%, 10%, 0.05) 50%,
    hsla(240, 5.88%, 10%, 0.11) 55.5%,
    hsla(240, 5.88%, 10%, 0.66) 75%,
    hsla(240, 5.88%, 10%, 0.88) 83.3%,
    hsl(240, 5.88%, 10%) 100%
  );
}

#artist-gradient-bottom {
  background: linear-gradient(0deg,
  hsl(240, 5.88%, 10%) 0%,
  hsla(240, 5.88%, 10%, 0.738) 19%,
  hsla(240, 5.88%, 10%, 0.541) 34%,
  hsla(240, 5.88%, 10%, 0.382) 47%,
  hsla(240, 5.88%, 10%, 0.278) 56.5%,
  hsla(240, 5.88%, 10%, 0.194) 65%,
  hsla(240, 5.88%, 10%, 0.126) 73%,
  hsla(240, 5.88%, 10%, 0.075) 80.2%,
  hsla(240, 5.88%, 10%, 0.042) 86.1%,
  hsla(240, 5.88%, 10%, 0.021) 91%,
  hsla(240, 5.88%, 10%, 0.008) 95.2%,
  hsla(240, 5.88%, 10%, 0.002) 98.2%,
  hsla(240, 5.88%, 10%, 0) 100%
  );
}

#artist-gradient-right {
  background: linear-gradient(-90deg,
  hsl(240, 5.88%, 10%) 0%,
  hsla(240, 5.88%, 10%, 0.738) 19%,
  hsla(240, 5.88%, 10%, 0.541) 34%,
  hsla(240, 5.88%, 10%, 0.382) 47%,
  hsla(240, 5.88%, 10%, 0.278) 56.5%,
  hsla(240, 5.88%, 10%, 0.194) 65%,
  hsla(240, 5.88%, 10%, 0.126) 73%,
  hsla(240, 5.88%, 10%, 0.075) 80.2%,
  hsla(240, 5.88%, 10%, 0.042) 86.1%,
  hsla(240, 5.88%, 10%, 0.021) 91%,
  hsla(240, 5.88%, 10%, 0.008) 95.2%,
  hsla(240, 5.88%, 10%, 0.002) 98.2%,
  hsla(240, 5.88%, 10%, 0) 100%
  );
}

#artist-gradient-left {
  background: linear-gradient(90deg,
  hsl(240, 5.88%, 10%) 0%,
  hsla(240, 5.88%, 10%, 0.738) 19%,
  hsla(240, 5.88%, 10%, 0.541) 34%,
  hsla(240, 5.88%, 10%, 0.382) 47%,
  hsla(240, 5.88%, 10%, 0.278) 56.5%,
  hsla(240, 5.88%, 10%, 0.194) 65%,
  hsla(240, 5.88%, 10%, 0.126) 73%,
  hsla(240, 5.88%, 10%, 0.075) 80.2%,
  hsla(240, 5.88%, 10%, 0.042) 86.1%,
  hsla(240, 5.88%, 10%, 0.021) 91%,
  hsla(240, 5.88%, 10%, 0.008) 95.2%,
  hsla(240, 5.88%, 10%, 0.002) 98.2%,
  hsla(240, 5.88%, 10%, 0) 100%
  );
}

</style>
