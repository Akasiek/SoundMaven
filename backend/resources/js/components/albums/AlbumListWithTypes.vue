<script setup lang="ts">

import { Link } from "@inertiajs/vue3";
import AlbumList from "@/components/albums/AlbumList.vue";

const { typeCount } = defineProps<{
  albums: (ExtendedAlbum | Album)[],
  typeCount: Record<string, number>,
  handleLink: (params: Object) => string
}>();

const TYPE_BUTTON_CLASS = 'px-3 py-2 rounded-md w-full h-fit text-left transition-colors duration-150 cursor-pointer';
const TYPE_ACTIVE_BUTTON_CLASS = 'text-zinc-100 bg-zinc-800';
const TYPE_INACTIVE_BUTTON_CLASS = 'text-zinc-400 hover:bg-zinc-800';

const chosenType = route().queryParams['type'] ?? null;

const getButtonClasses = (isActive: boolean) => {
  return `${TYPE_BUTTON_CLASS} ${isActive ? TYPE_ACTIVE_BUTTON_CLASS : TYPE_INACTIVE_BUTTON_CLASS}`;
};
</script>

<template>
  <div class="grid grid-cols-[auto_1fr] space-x-5">
    <div class="space-y-2 grid min-w-48 h-fit">
      <Link
        v-for="(count, name) in typeCount"
        :key="name"
        :class="getButtonClasses(name === 'All' ? !chosenType : name === chosenType)"
        :href="name === 'All' ? handleLink({}) : handleLink({ type: name })"
        prefetch
        preserve-scroll
      >
        {{ name }} ({{ count }})
      </Link>
    </div>

    <div class="pl-6 border-l border-zinc-800">
      <div class="space-y-6">
        <AlbumList :albums="albums" :show-artist="false" :show-date="true" :group-by-type="!chosenType"/>
      </div>
    </div>
  </div>
</template>
