<script setup lang="ts">
import AlbumList from "@/components/albums/AlbumList.vue";

interface Props {
  albums: ExtendedAlbum[];
}

defineProps<Props>();
</script>

<template>
  <div class="container mx-auto">
    <div class="py-12">
      <AlbumList :albums="albums" :show-artist="true"/>
    </div>
  </div>
</template>
