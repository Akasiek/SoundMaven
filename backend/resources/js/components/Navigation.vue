<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import NavAvatar from "@/components/NavAvatar.vue";
import { useAuthUser } from "@/composables/useAuthUser";
import NavSearchComponent from "@/components/navSearch/NavSearchComponent.vue";

const links = [
  { name: 'Home', url: route('home') },
  { name: 'Artists', url: route('artists.list') },
  { name: 'Contact', url: '/contact' },
];

const user = useAuthUser();

</script>

<template>
  <nav class="fixed inset-x-0 top-0 w-full h-18 bg-zinc-800 px-4 sm:px-6 lg:px-8 z-30" id="top-nav">
    <div class="container w-full mx-auto flex justify-between items-center h-full">

      <Link prefetch class="block px-5 -ml-5 py-5" :href="route('home')">
        <img src="/images/logo.svg" alt="Logo" class="w-48">
      </Link>

      <div class="flex items-center gap-x-5">

        <NavSearchComponent/>

        <hr class="border-l border-zinc-600 h-6">

        <Link
          prefetch
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
          <Link prefetch :href="route('login')" class="font-bold hover:text-zinc-300 hover:underline">
            Log In
          </Link>
        </div>
      </div>
    </div>
  </nav>
</template>
