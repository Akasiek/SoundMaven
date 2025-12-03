<script setup lang="ts">
import { InertiaForm } from "@inertiajs/vue3";
import InputError from "@/components/inputs/InputError.vue";
import { onMounted, ref } from "vue";

defineProps<{
  form: InertiaForm<{
    favorite_artist: { id: string, label: string } | null;
    favorite_artist_id?: string;
  }>;
}>();

const artistOptions = ref<{ id: string, label: string }[]>([]);

const fetchArtists = async (search: string, loading: (loading: boolean) => void) => {
  loading(true);
  const response = await fetch(route('artists.fetchRaw', { search }));
  const data = await response.json();

  loading(false);

  artistOptions.value = data.map((artist: { id: string, name: string }) => ({
    id: artist.id,
    label: artist.name,
  }));
};

onMounted(() => {
  fetchArtists('', (() => false));
});
</script>

<template>
  <div class=" grid grid-cols-2 gap-x-6 gap-y-4 items-center justify-center border-y border-zinc-700" id="update-profile-section">
    <h3 class="col-span-2 mb-2"> Favorite Artist </h3>
    <div class="grid gap-2 col-span-2">
      <v-select id="artist" @search="fetchArtists" v-model="form.favorite_artist" :options="artistOptions" :clearable="false"/>
      <InputError :message="form.errors.favorite_artist_id"/>
    </div>
  </div>
</template>
