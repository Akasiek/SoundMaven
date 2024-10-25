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
    <section id="hero" class="flex gap-10 mx-auto w-fit">
      <NuxtImg v-if="album.cover_image" class="h-80" :src="album.cover_image" :alt="`${album.title} album cover`"/>

      <div class="font-serif my-auto">
        <h2 class="text-2xl"> {{ album.artist.name }} </h2>
        <h1 class="text-4xl font-bold mb-2"> {{ album.title }} </h1>
        <h4 class="text-lg text-zinc-400 mb-2">
          {{ album.release_date }} | {{ album.type }}
        </h4>
        <p v-if="album.genres">
          <template v-for="(genre, index) in album.genres" :key="genre.id">
            <span class="italic">
              {{ genre.name }}
            </span>
            <template v-if="index !== album.genres.length - 1"> • </template>
          </template>
        </p>
      </div>
    </section>
  </main>
</template>
