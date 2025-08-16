<script setup lang="ts">
import DefaultSection from "@/components/DefaultSection.vue";
import AlbumTrackListForm from "@/components/albums/Show/AlbumTrackListForm.vue";

const { album } = defineProps<{ album: ExtendedAlbum }>();

const discs = album.tracks.reduce((acc, { disc, ...track }) => {
  acc[disc] = acc[disc] || [];
  acc[disc].push({ disc, ...track });
  return acc;
}, {} as Record<number, Track[]>);
</script>

<template>
  <DefaultSection class="p-6 space-y-5">
    <div class="flex items-center gap-3">
      <h2 class="text-2xl font-bold">
        Tracks
      </h2>
      <AlbumTrackListForm :album="album" />
    </div>
    <template v-if="Object.keys(discs).length > 0">
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
    </template>
    <template v-else>
      <p class="text-zinc-400">
        No tracklist found for this album.
      </p>
    </template>
  </DefaultSection>
</template>
