<script setup lang="ts">
const { params } = useRoute();
const router = useRouter();
const config = useRuntimeConfig();

const slug = params.slug;
const album = await fetchAlbum(slug, config);

if (!album) {
  router.replace('/404');
}

useHead({
  title: `${album?.title} - Album page | SoundMaven`,
});

</script>

<template>
  <main v-if="album" class="py-12">
    <AlbumViewHero :album="album" />
    <AlbumViewTrackList :album="album" />
  </main>
</template>
