<script setup lang="ts">

import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
</script>

<template>
    <PrimaryLayout>
        <div class="w-full min-h-screen flex items-center justify-center">
            <main class="bg-zinc-800 p-8 rounded-lg shadow-lg w-full max-w-sm border border-zinc-700">
                <slot/>
            </main>
        </div>
    </PrimaryLayout>
</template>

<style scoped>

</style>
