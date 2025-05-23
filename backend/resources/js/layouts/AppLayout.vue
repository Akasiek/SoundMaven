<script setup lang="ts">
import Navigation from "@/components/Navigation.vue";
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
</script>

<template>
    <PrimaryLayout>
        <Navigation/>
        <main class="mt-18 px-4 sm:px-6 lg:px-8">
            <slot/>
        </main>
    </PrimaryLayout>
</template>

<style scoped>

</style>
