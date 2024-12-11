<script setup lang="ts">
import type Album from "~/interfaces/Album";

const { album } = defineProps<{
  album: Album;
}>();
</script>

<template>
  <section v-if="album.tracks.length > 0" class="my-12">
    <h1 class="text-3xl font-black tracking-tight">
      Tracks
    </h1>

    <hr class="my-2 border-accent-primary border-t-2 border-0 w-64">

    <ol class="list-decimal list-inside font-serif py-4">
      <template v-for="(track, index) in album.tracks" :key="track.id">
        <li class="flex justify-between items-center align-baseline">
          <span class="mr-2"> {{ index + 1 }}. </span>
          <span class="font-bold w-full"> {{ track.title }} </span>
          <span class="ml-auto"> {{ track.length_in_minutes }} </span>
        </li>
        <template v-if="index !== album.tracks.length - 1">
          <hr class="border-zinc-600 my-4">
        </template>
      </template>
    </ol>

  </section>
</template>