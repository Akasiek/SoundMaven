<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/favicon.png">
    </Head>
    <div class="dark font-serif bg-zinc-900 text-zinc-100 min-h-screen">
        <slot/>
    </div>
</template>

<style scoped>

</style>
