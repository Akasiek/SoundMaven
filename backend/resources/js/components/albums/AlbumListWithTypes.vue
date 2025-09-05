<script setup lang="ts">
import { computed, onMounted, ref, watch } from "vue";
import AlbumList from "@/components/albums/AlbumList.vue";
import { useComputedFromStorage } from "@/composables/useComputedFromStorage";

const { albums, storageKey = 'type' } = defineProps<{ albums: (ExtendedAlbum | Album)[], storageKey?: string }>();

const TYPE_SORT_ORDER = ['LP', 'EP', 'Single', 'Live', 'Compilation', 'Soundtrack', 'Remix', 'Other'];
const TYPE_BUTTON_CLASS = 'px-3 py-2 rounded-md w-full h-fit text-left transition-colors duration-150 cursor-pointer';
const TYPE_ACTIVE_BUTTON_CLASS = 'text-zinc-100 bg-zinc-800';
const TYPE_INACTIVE_BUTTON_CLASS = 'text-zinc-400 hover:bg-zinc-800';

const types = ref<Array<{ name: string; albums: (ExtendedAlbum | Album)[]; }>>([]);
const chosenType = useComputedFromStorage<string | null>(storageKey, null);

const processAlbums = (albumList: (ExtendedAlbum | Album)[]) => {
  const groupedTypes = groupAlbumsByType(albumList);
  sortTypesByPredefinedOrder(groupedTypes);
  types.value = groupedTypes;
};

const groupAlbumsByType = (albumList: (ExtendedAlbum | Album)[]): Array<{ name: string; albums: (ExtendedAlbum | Album)[]; }> => {
  const groupedTypes: Array<{ name: string; albums: (ExtendedAlbum | Album)[]; }> = [];

  albumList.forEach((album: ExtendedAlbum | Album) => {
    const typeName = album.type || 'Other';
    const existingType = groupedTypes.find(t => t.name === typeName);

    if (existingType) {
      existingType.albums.push(album);
    } else {
      groupedTypes.push({ name: typeName, albums: [album] });
    }
  });

  return groupedTypes;
};

const sortTypesByPredefinedOrder = (groupedTypes: Array<{ name: string; albums: (ExtendedAlbum | Album)[]; }>): void => {
  groupedTypes.sort((a, b) => getTypeSortIndex(a.name) - getTypeSortIndex(b.name));
};

const getTypeSortIndex = (typeName: string): number => {
  const index = TYPE_SORT_ORDER.indexOf(typeName);
  return index === -1 ? TYPE_SORT_ORDER.length : index;
};

const getButtonClasses = (isActive: boolean) => {
  return `${TYPE_BUTTON_CLASS} ${isActive ? TYPE_ACTIVE_BUTTON_CLASS : TYPE_INACTIVE_BUTTON_CLASS}`;
};

const showAllTypes = computed(() => chosenType.value === null);
const selectedTypeData = computed(() => types.value.find(type => type.name === chosenType.value));

onMounted(() => {
  processAlbums(albums);
});

watch(() => albums, processAlbums, { immediate: true });
</script>

<template>
  <div class="grid grid-cols-[auto_1fr] space-x-5">
    <div class="space-y-2 grid min-w-48 h-fit">
      <button
        :class="getButtonClasses(types.length > 0 && showAllTypes)"
        @click="chosenType = null"
      >
        All ({{ albums.length }})
      </button>
      <button
        v-for="type in types"
        :key="type.name"
        :class="getButtonClasses(chosenType === type.name)"
        @click="chosenType = type.name"
      >
        {{ type.name }} ({{ type.albums.length }})
      </button>
    </div>

    <div class="pl-6 border-l border-zinc-800">
      <div v-show="showAllTypes">
        <div
          v-for="(subType, index) in types"
          :key="subType.name"
          class="space-y-4 mb-8 pb-8"
          :class="{ 'border-b border-zinc-800': index !== types.length - 1 }"
        >
          <h2 class="text-2xl font-bold">{{ subType.name }}</h2>
          <hr class="w-24 mt-4 mb-6 border-zinc-800">
          <AlbumList :albums="subType.albums" :show-artist="false" :show-date="true"/>
        </div>
      </div>

      <div v-if="selectedTypeData" class="space-y-6">
        <AlbumList :albums="selectedTypeData.albums" :show-artist="false" :show-date="true"/>
      </div>
    </div>
  </div>
</template>
