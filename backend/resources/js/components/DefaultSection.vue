<script setup lang="ts">
import { cn } from '@/lib/utils';

import type { HTMLAttributes } from "vue";

const props = defineProps<{ class?: HTMLAttributes['class'] }>()
</script>

<template>
  <section :class="cn('container mx-auto rounded-lg flex p-10 gap-10 bg-zinc-850 border-2 border-zinc-800 shadow-xl', props.class)">
    <slot/>
  </section>
</template>
