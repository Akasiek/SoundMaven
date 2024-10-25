<script setup lang="ts">
import type Album from "~/interfaces/Album";

const route = useRoute();
const router = useRouter();
const config = useRuntimeConfig();

const slug = route.params.slug;

// Fetch album data
const response = await useFetch<{
  data: Album;
}>(`${config.public.apiUrl}/albums/${slug}`);
const album = response.data.value?.data;

if (!album) {
  // Redirect to 404 page
  await router.push('/404');
}
</script>

<template>
  <div>
    <h1>Album: {{ album?.title }}</h1>
    <p>
      Released: {{ album?.release_date }}
    </p>
    <img class="h-96" :src="album?.cover_image" alt="Album cover">
  </div>
</template>
