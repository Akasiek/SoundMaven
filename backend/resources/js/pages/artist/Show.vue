<script setup lang="ts">
import ArtistHero from "@/components/artists/ArtistHero.vue";
import AlbumListWithTypes from "@/components/albums/AlbumListWithTypes.vue";

defineProps<{ artist: { data: ExtendedArtist } }>();
</script>

<template>
  <main class="container mx-auto">
    <ArtistHero :artist="artist.data"/>

    <section class="pt-24 pb-12">
      <AlbumListWithTypes :albums="artist.data.albums" :storage-key="`${artist.data.slug}_show-view_album-type_default`"/>
    </section>
  </main>

</template>
