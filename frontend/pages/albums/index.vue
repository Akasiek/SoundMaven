<script setup lang="ts">
import type Album from "~/interfaces/Album";

const config = useRuntimeConfig();
const albums = await useFetch<{ data: Album[] }>(`${config.public.apiUrl}/albums`, {
  query: {
    include: "genres",
  },
});

</script>

<template>
  <main class="py-8 bg-dark-secondary">

    <div class="my-8 px-4">
      <h2 class="text-2xl mb-2">Albums</h2>
      <div class="grid grid-cols-4 gap-4">

        <template v-for="album in albums.data.value?.data" :key="album.id">
          <AlbumCard :album="album" />
        </template>
      </div>
    </div>
  </main>
</template>

<style scoped>

</style>