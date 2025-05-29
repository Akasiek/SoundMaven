<script setup lang="ts">
defineProps<{
    album: ExtendedAlbum;
    showArtist?: boolean;
    showDate?: boolean;
}>();
</script>

<template>
    <a :href="`/album/${album.slug}`" class="block group transition duration-300 ease-in-out">
        <div
            class="w-full aspect-square overflow-hidden relative transition duration-300 ease-in-out border-2 rounded-md border-zinc-800 group-hover:border-zinc-600">
            <img v-if="album.cover_image" :src="album.cover_image" :alt="album.title" class="w-full h-full object-cover object-center"/>
            <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300">
                <rect width="300" height="300" fill="#27262AFF"></rect>
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="serif" font-size="26px" fill="#FAFAFAFF">
                    Missing cover
                </text>
            </svg>
        </div>

        <div
            class="grid grid-cols-[1fr_auto] px-3 mt-4 py-3 border-2 rounded-md border-zinc-800 group-hover:border-zinc-600 transition duration-300 ease-in-out">
            <div class="space-y-1">
                <h2 class="text-lg font-bold">{{ album.title }}</h2>
                <a v-show="showArtist || true" :href="route('artists.show', album.artist.slug)" class="hover:underline">
                    <h3 class="text-base">{{ album.artist.name }}</h3>
                </a>
                <p class="text-sm font-sans text-zinc-400" v-show="showDate || false">
                    {{ new Date(album.release_date).toLocaleDateString() }}
                </p>
            </div>

            <div :class="`px-4 py-3 text-3xl font-black flex justify-center leading-none ${album.rating_color}`">
                {{ album.average_rating }}
            </div>
        </div>
    </a>
</template>
