<script setup lang="ts">

import Navigation from "@/components/Navigation.vue";
</script>

<template>
    <Navigation/>
    <main class="font-serif bg-zinc-900 text-zinc-100 mt-18 px-4 sm:px-6 lg:px-8">
        <slot />
    </main>
</template>

<style scoped>

</style>
