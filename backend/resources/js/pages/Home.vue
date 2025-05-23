<script setup lang="ts">
import AlbumCard from "@/components/albums/AlbumCard.vue";

interface Props {
    albums: { data: ExtendedAlbum[] };
}

defineProps<Props>();
</script>

<template>
        <div class="container mx-auto">
            <div class="grid grid-cols-4 gap-x-6 gap-y-12 pt-10">
                <template v-for="album in albums.data" :key="album.id">
                    <AlbumCard :album/>
                </template>
            </div>
        </div>
</template>
