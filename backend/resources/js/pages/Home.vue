<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AlbumCard from "@/components/albums/AlbumCard.vue";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";

interface Props {
    albums: { data: ExtendedAlbum[] };
}

defineProps<Props>();
</script>

<template>
    <Head title="Welcome"/>
    <PrimaryLayout>

        <div class="container mx-auto px-4">
            <div class="grid grid-cols-4 gap-x-5 gap-y-10 pt-10">
                <template v-for="album in albums.data" :key="album.id">
                    <AlbumCard :album :showArtist="true"/>
                </template>
            </div>
        </div>
    </PrimaryLayout>
</template>
