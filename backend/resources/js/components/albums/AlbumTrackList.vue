<script setup lang="ts">

const { album } = defineProps<{ album: ExtendedAlbum }>();

const discs = album.tracks.reduce((acc, { disc, ...track }) => {
  acc[disc] = acc[disc] || [];
  acc[disc].push({ disc, ...track });
  return acc;
}, {} as Record<number, Track[]>);
</script>

<template>
  <div class="bg-zinc-850 border-2 border-zinc-800 shadow-xl rounded-lg p-6 space-y-5" v-if="Object.keys(discs).length > 0">
    <h2 class="text-2xl font-bold"> Tracks </h2>
    <div class="space-y-5">
      <div v-for="(tracks, discNumber) in discs" :key="discNumber" class="space-y-2">
        <h3 class="text-lg font-semibold text-zinc-100" v-if="Object.keys(discs).length > 1"> Disc {{ discNumber }} </h3>
        <ol class="pl-5 list-decimal text-zinc-400 space-y-2 text-base">
          <li v-for="track in tracks" :key="track.id">
            <span class="text-zinc-50">{{ track.title }}</span>
            <span v-if="track.length_formatted" class="text-zinc-400"> ({{ track.length_formatted }})</span>
            <hr class="border-zinc-700 mt-2 -ml-5">
          </li>
        </ol>
      </div>
    </div>
    <div class="text-zinc-400">
      Total length: <span class="font-bold text-zinc-50"> {{ album.total_length_formatted }} </span>
    </div>
  </div>
</template>
