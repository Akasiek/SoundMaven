<script setup lang="ts">

import { Link, usePage } from '@inertiajs/vue3'
import { SharedData, User } from "@/types";
import NavAvatar from "@/components/NavAvatar.vue";


const links = [
    { name: 'Home', url: '/' },
    { name: 'Artists', url: route('artists.list') },
    { name: 'Contact', url: '/contact' },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;


</script>

<template>
    <nav class="fixed inset-x-0 top-0 w-full h-18 bg-zinc-800 px-4 sm:px-6 lg:px-8 z-50">
        <div class="container w-full mx-auto flex justify-between items-center h-full">

            <a class="block w-48" href="/">
                <img src="/images/logo.svg" alt="Logo">
            </a>

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
