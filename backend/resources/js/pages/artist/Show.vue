<script setup lang="ts">
import ArtistHero from "@/components/artists/ArtistHero.vue";
import AlbumListWithTypes from "@/components/albums/AlbumListWithTypes.vue";

const { artist } = defineProps<{ artist: ExtendedArtist, albums: ExtendedAlbum[], typeCount: Record<string, number> }>();

const handleLink = (params: Object) => route('artists.show', { artist: artist, ...params });
</script>

<template>
  <main class="container mx-auto">
    <ArtistHero :artist="artist"/>

    <section class="pt-24 pb-12">
      <AlbumListWithTypes
        :albums="albums" :type-count="typeCount" :storage-key="`${artist.slug}_show-view_album-type_default`" :handle-link="handleLink"
      />
    </section>
  </main>

</template>
