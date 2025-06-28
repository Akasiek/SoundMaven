<script setup lang="ts">
defineProps<{ artist: Artist }>()
</script>

<template>
  <section class="w-full relative scale-105">
    <div id="artist-gradient-bottom" class="absolute -inset-1"></div>
    <div id="artist-gradient-right" class="absolute -inset-1"></div>
    <div id="artist-gradient-left" class="absolute -inset-1"></div>
    <div id="artist-radial-gradient" class="absolute inset-0"></div>
    <div class="aspect-video w-full">
      <img :src="artist.background_image" :alt="`${artist.name} background`" class="w-full h-full object-center object-cover">
    </div>

    <div class="absolute inset-x-0 bottom-10 mx-16">
      <h1 class="text-6xl font-black text-white mb-12">
        {{ artist.name }}
      </h1>
    </div>
  </section>
</template>

<style scoped>
#artist-radial-gradient {
  background: radial-gradient(
    ellipse at top,
    transparent 0%,
    transparent 50%,
    hsla(240, 5.88%, 10%, 0.322) 63%,
    hsla(240, 5.88%, 10%, 0.738) 76%,
    hsl(240, 5.88%, 10%) 100%
  );
}

#artist-gradient-bottom {
  background: linear-gradient(0deg,
  hsl(240, 5.88%, 10%) 0%,
  hsla(240, 5.88%, 10%, 0.738) 9.5%,
  hsla(240, 5.88%, 10%, 0.541) 17%,
  hsla(240, 5.88%, 10%, 0.382) 23.5%,
  hsla(240, 5.88%, 10%, 0.278) 28.25%,
  hsla(240, 5.88%, 10%, 0.194) 32.5%,
  hsla(240, 5.88%, 10%, 0.126) 36.5%,
  hsla(240, 5.88%, 10%, 0.075) 40.1%,
  hsla(240, 5.88%, 10%, 0.042) 43.05%,
  hsla(240, 5.88%, 10%, 0.021) 45.5%,
  hsla(240, 5.88%, 10%, 0.008) 47.6%,
  hsla(240, 5.88%, 10%, 0.002) 49.1%,
  hsla(240, 5.88%, 10%, 0) 50%
  );
}

#artist-gradient-right {
  background: linear-gradient(90deg,
  hsl(240, 5.88%, 10%) 0%,
  hsla(240, 5.88%, 10%, 0.738) 9.5%,
  hsla(240, 5.88%, 10%, 0.541) 17%,
  hsla(240, 5.88%, 10%, 0.382) 23.5%,
  hsla(240, 5.88%, 10%, 0.278) 28.25%,
  hsla(240, 5.88%, 10%, 0.194) 32.5%,
  hsla(240, 5.88%, 10%, 0.126) 36.5%,
  hsla(240, 5.88%, 10%, 0.075) 40.1%,
  hsla(240, 5.88%, 10%, 0.042) 43.05%,
  hsla(240, 5.88%, 10%, 0.021) 45.5%,
  hsla(240, 5.88%, 10%, 0.008) 47.6%,
  hsla(240, 5.88%, 10%, 0.002) 49.1%,
  hsla(240, 5.88%, 10%, 0) 50%
  );
}

#artist-gradient-left {
  background: linear-gradient(-90deg,
  hsl(240, 5.88%, 10%) 0%,
  hsla(240, 5.88%, 10%, 0.738) 9.5%,
  hsla(240, 5.88%, 10%, 0.541) 17%,
  hsla(240, 5.88%, 10%, 0.382) 23.5%,
  hsla(240, 5.88%, 10%, 0.278) 28.25%,
  hsla(240, 5.88%, 10%, 0.194) 32.5%,
  hsla(240, 5.88%, 10%, 0.126) 36.5%,
  hsla(240, 5.88%, 10%, 0.075) 40.1%,
  hsla(240, 5.88%, 10%, 0.042) 43.05%,
  hsla(240, 5.88%, 10%, 0.021) 45.5%,
  hsla(240, 5.88%, 10%, 0.008) 47.6%,
  hsla(240, 5.88%, 10%, 0.002) 49.1%,
  hsla(240, 5.88%, 10%, 0) 50%
  );
}

</style>
