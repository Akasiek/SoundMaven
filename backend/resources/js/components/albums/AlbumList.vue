<script setup lang="ts">
import AlbumCard from "@/components/albums/AlbumCard.vue";
import { computed } from "vue";

const props = withDefaults(
  defineProps<{
    albums: ExtendedAlbum[] | Album[],
    showArtist?: boolean,
    showDate?: boolean
  }>(),
  {
    showArtist: true,
    showDate: false
  }
);

function sortAlbumsByReleaseDate(albums: ExtendedAlbum[] | Album[]): (ExtendedAlbum | Album)[] {
  return [...albums].sort((a, b) => {
    const dateA = a.release_date ? new Date(a.release_date).getTime() : 0;
    const dateB = b.release_date ? new Date(b.release_date).getTime() : 0;
    return dateB - dateA;
  });
}

const sortedAlbums = computed(() => sortAlbumsByReleaseDate(props.albums));

</script>

<template>
  <div class="grid xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-6 gap-y-12">
    <div v-for="album in sortedAlbums" :key="album.id">
      <AlbumCard :album="album" :show-artist="showArtist" :show-date="showDate"/>
    </div>
  </div>
</template>
