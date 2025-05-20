<script setup lang="ts">
import Navigation from "@/components/Navigation.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/favicon.png">
    </Head>
    <Navigation/>
    <main class="font-serif bg-zinc-900 text-zinc-100 mt-18 px-4 sm:px-6 lg:px-8">
        <slot/>
    </main>
</template>

<style scoped>

</style>
