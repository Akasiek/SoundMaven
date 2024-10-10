<script lang="ts" setup>
import { useAuthStore } from "~/store/auth";

const config = useRuntimeConfig();
const store = useAuthStore();
const { isAuth } = storeToRefs(store)
const albums = await useFetch<{
  data: {
    id: number;
    title: string;
  }[];
}>(`${config.public.apiUrl}/albums`);

const handleLogout = async () => {
  await store.logout();
};

</script>

<template>
  <main>

    <h1 class="text-3xl">Hello world!</h1>

    <p>
      User is {{ isAuth ? 'logged in' : 'not logged in' }}
    </p>

    <nuxt-link v-if="!isAuth" href="/login" class="bg-green-300 py-2 px-4 rounded m-4 inline-block">
      Login
    </nuxt-link>
    <button v-else class="bg-red-300 py-2 px-4 rounded m-4 inline-block" @click="handleLogout">
      Logout
    </button>

    <nuxt-link href="/about">
      About
    </nuxt-link>

    <div class="my-8 px-4">
      <h2 class="text-2xl mb-2">Albums</h2>
      <ul>
        <li v-for="album in albums.data.value?.data" :key="album.id">
          {{ album.title }}
        </li>
      </ul>
    </div>
  </main>

</template>
