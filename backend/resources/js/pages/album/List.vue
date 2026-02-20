<script setup lang="ts">
import AlbumCard from "@/components/albums/AlbumCard.vue";
import Pagination from "@/components/Pagination.vue";

defineProps<{ albums: PaginatedData<Album> }>();
</script>

<template>
  <main class="container mx-auto pt-12 pb-24">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-8 gap-y-8 md:gap-y-12">
      <template v-for="album in albums.data" :key="album.id">
        <AlbumCard :album="album" :show-artist="true"/>
      </template>
    </div>

    <Pagination :meta="albums.meta" class="mt-12"/>

  </main>
</template>
