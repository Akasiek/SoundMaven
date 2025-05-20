<script setup lang="ts">

const links = [
    { name: 'Home', url: '/' },
    { name: 'Artists', url: '/artists' },
    { name: 'Contact', url: '/contact' },
];
</script>

<template>
    <nav class="fixed inset-x-0 top-0 w-full h-18 bg-zinc-800 px-4 sm:px-6 lg:px-8 z-50">
        <div class="container w-full mx-auto flex justify-between items-center h-full">

            <a class="block w-48" href="/">
                <img src="/images/logo.svg" alt="Logo">
            </a>

            <div class="flex gap-x-5">
                <a
                    v-for="link in links"
                    :key="link.name"
                    :href="link.url"
                    class="font-bold text-zinc-100 hover:text-zinc-300 hover:underline"
                >
                    {{ link.name }}
                </a>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
