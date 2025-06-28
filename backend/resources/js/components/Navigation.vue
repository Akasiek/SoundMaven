<script setup lang="ts">

import { Link } from '@inertiajs/vue3'
import NavAvatar from "@/components/NavAvatar.vue";
import { useAuthUser } from "@/composables/useAuthUser";


const links = [
  { name: 'Home', url: route('home') },
  { name: 'Artists', url: route('artists.list') },
  { name: 'Contact', url: '/contact' },
];

const user = useAuthUser();

</script>

<template>
  <nav class="fixed inset-x-0 top-0 w-full h-18 bg-zinc-800 px-4 sm:px-6 lg:px-8 z-50">
    <div class="container w-full mx-auto flex justify-between items-center h-full">

      <Link class="block w-48" :href="route('home')">
        <img src="/images/logo.svg" alt="Logo">
      </Link>

      <div class="flex items-center gap-x-5">
        <Link
          v-for="link in links"
          :key="link.name"
          :href="link.url"
          class="font-bold hover:text-zinc-300 hover:underline"
        >
          {{ link.name }}
        </Link>

        <hr class="border-l border-zinc-600 h-6">

        <NavAvatar v-if="user" :user="user"/>
        <div v-else>
          <Link :href="route('login')" class="font-bold hover:text-zinc-300 hover:underline">
            Log In
          </Link>
        </div>
      </div>
    </div>
  </nav>
</template>
