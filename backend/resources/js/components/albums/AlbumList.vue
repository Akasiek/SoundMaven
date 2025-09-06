<script setup lang="ts">
import AlbumCard from "@/components/albums/AlbumCard.vue";
import { computed } from "vue";

const { albums, groupByType } = withDefaults(
  defineProps<{
    albums: (ExtendedAlbum | Album)[],
    showArtist?: boolean,
    showDate?: boolean
    groupByType?: boolean
  }>(),
  {
    showArtist: true,
    showDate: false,
    groupByType: false
  }
);

const groupedAlbumsByType = computed(() => {
  if (!groupByType) {
    return [];
  }

  const groups = albums.reduce((acc, album) => {
    const type = album.type || 'Other';
    acc[type] = acc[type] || [];
    acc[type].push(album);

    return acc;
  }, {} as Record<string, (ExtendedAlbum | Album)[]>);

  return Object.entries(groups).map(([type, albums]) => ({ name: type, albums }));
});

</script>

<template>
  <template v-if="!groupByType">
    <div class="grid xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12">
      <div v-for="album in albums" :key="album.id">
        <AlbumCard :album="album" :show-artist="showArtist" :show-date="showDate"/>
      </div>
    </div>
  </template>

  <template v-else>
    <div
      v-for="({name, albums}, index) in groupedAlbumsByType"
      :key="name"
      class="space-y-4 mb-8 pb-8"
      :class="{ 'border-b border-zinc-800': index !== groupedAlbumsByType.length - 1 }"
    >
      <h2 class="text-2xl font-bold">{{ name }}</h2>
      <hr class="w-24 mt-4 mb-6 border-zinc-800">
      <div class="grid xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12">
        <div v-for="album in albums" :key="album.id">
          <AlbumCard :album="album" :show-artist="showArtist" :show-date="showDate"/>
        </div>
      </div>
    </div>
  </template>
</template>
