<script setup lang="ts">
import AlbumList from "@/components/albums/AlbumList.vue";
import ArtistHero from "@/components/artists/ArtistHero.vue";

defineProps<{ artist: { data: ExtendedArtist } }>();
</script>

<template>
  <main class="container mx-auto">
    <ArtistHero :artist="artist.data"/>

    <section class="pt-24 pb-12">
       <AlbumList :albums="artist.data.albums" :show-artist="false" :show-date="true"/>
    </section>
  </main>

</template>

<style scoped>

</style>
