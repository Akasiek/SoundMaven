<script lang="ts" setup>
import { useAuthStore } from "~/store/auth";
import type Album from "~/interfaces/Album";

const config = useRuntimeConfig();
const store = useAuthStore();
const { isAuth } = storeToRefs(store)
const albums = await useFetch<{
  data: Album[];
}>(`${config.public.apiUrl}/albums`, {
  query: {
    perPage: 200,
  },
});

const handleLogout = async () => {
  await store.logout();
};

</script>

<template>
  <main class="py-8">

    <h1 class="text-3xl">Hello world!</h1>

    <p>
      User is {{ isAuth ? 'logged in' : 'not logged in' }}
    </p>

    <NuxtLink v-if="!isAuth" to="/login" class="bg-green-300 py-2 px-4 rounded m-4 inline-block">
      Login
    </NuxtLink>
    <button v-else class="bg-red-300 py-2 px-4 rounded m-4 inline-block" @click="handleLogout">
      Logout
    </button>

    <NuxtLink to="/about">
      About
    </NuxtLink>

    <div class="my-8 px-4">
      <h2 class="text-2xl mb-2">Albums</h2>
      <ul>
        <li v-for="album in albums.data.value?.data" :key="album.id">
          <NuxtLink :to="`/album/${album.slug}`">{{ album.title }}</NuxtLink>
        </li>
      </ul>
    </div>
  </main>

</template>
