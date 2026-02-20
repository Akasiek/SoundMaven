<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps<{ meta: PaginatedDataMeta }>();
</script>

<template>
  <nav>

    <div class="flex justify-center items-center space-x-3">
      <template v-for="page in meta.links" :key="page.label">

        <Link
          preserve-scroll
          v-if="page.label !== '...'"
          :href="page.url || '#'"
          class="px-2.5 py-1 rounded-md border border-zinc-700 transition-colors duration-300"
          :class="{
            'bg-green-500 text-zinc-800': page.active,
            'bg-zinc-800 hover:bg-zinc-700': !page.active
          }"
          v-html="page.label"
          prefetch
        >
        </Link>
        <span v-else class="px-3 py-1 rounded-md  text-zinc-400">
          {{ page.label }}
        </span>
      </template>
    </div>

  </nav>
</template>
