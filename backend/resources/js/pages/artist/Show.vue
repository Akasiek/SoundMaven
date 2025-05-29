<script setup lang="ts">


defineProps<{ artist: { data: Artist } }>();
</script>

<template>
  <main class="max-w-7xl mx-auto">
    <section class="w-full relative">
      <div class="absolute inset-0 bg-gradient-to-t to-50% from-zinc-900 to-transparent"></div>
      <div class="aspect-video w-full">
        <img :src="artist.data.background_image" :alt="`${artist.data.name} background`" class="w-full h-full object-center object-cover">
      </div>

      <div class="absolute inset-x-0 bottom-10 mx-10">
        <h1 class="text-6xl font-black text-white mb-4">
          {{ artist.data.name }}
        </h1>
      </div>
    </section>

    <section class="my-12">
      <!-- <AlbumList :albums="artist.data.albums" :show-artist="false" /> -->
    </section>
  </main>

</template>

<style scoped>

</style>
