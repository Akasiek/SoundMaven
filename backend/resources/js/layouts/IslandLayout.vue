<script setup lang="ts">
import PrimaryLayout from "@/layouts/PrimaryLayout.vue";
import { cn } from "@/lib/utils";

const props = defineProps<{
    class?: string;
}>();
</script>

<template>
    <PrimaryLayout>
        <div class="w-full min-h-screen flex items-center justify-center">
            <main :class="cn('bg-zinc-800 p-8 rounded-lg shadow-lg w-full border border-zinc-700',
                'max-w-sm',
                props.class)"
            >
                <slot/>
            </main>
        </div>
    </PrimaryLayout>
</template>

<style scoped>

</style>
