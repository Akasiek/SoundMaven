<script setup lang="ts">
import { onMounted, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import DefaultSection from "@/components/DefaultSection.vue";
import { Input } from "@/components/shadcn/ui/input";
import { Label } from "@/components/shadcn/ui/label";
import { Button } from "@/components/shadcn/ui/button";
import { LoaderCircle, X } from "lucide-vue-next";
import InputError from "@/components/inputs/InputError.vue";

const { album } = defineProps<{ types: string[], album?: { data: ExtendedAlbum } }>();

const isUpdate = !!album && !!album.data;
const imagePreviewUrl = ref<string | null>(null);
const artistOptions = ref<{ id: string, label: string }[]>([]);

const form = useForm<{
  title: string;
  release_date: string; // ISO date string
  type: string; // e.g., 'LP', 'EP', etc.
  artist: { id: string, label: string } | null; // Artist object or null if not selected
  artist_id?: string; // Optional artist ID for form submission
  cover_image: File | null; // File object for the cover image
}>({
  title: album?.data.title || '',
  release_date: album?.data.release_date || new Date().toISOString().slice(0, 10), // Default to today
  type: album?.data.type || 'LP',
  artist: album?.data.artist ? { id: album.data.artist.id, label: album.data.artist.name } : null,
  artist_id: album?.data.artist ? album.data.artist.id : undefined,
  cover_image: null,
});

const submit = () => {
  form.artist_id = form.artist?.id;
  const formRoute = isUpdate
    ? route('albums.update', { album: album.data.slug })
    : route('albums.store');

  router.post(formRoute, {
    ...form.data(),
    _method: isUpdate ? 'put' : 'post',
  }, {
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.error('Form submission errors:', errors, form);
    },
  });
};

const fetchArtists = async (search: string, loading: (loading: boolean) => void) => {
  loading(true);
  const response = await fetch(route('artists.fetchRaw', { search }));
  const data = await response.json();

  loading(false);

  artistOptions.value = data.map((artist: { id: string, name: string }) => ({
    id: artist.id,
    label: artist.name,
  }));
};

onMounted(() => {
  const emptyLoading = () => false;
  fetchArtists('', emptyLoading);
});


const handleImageUpload = (event: Event): void => {
  const file = (event.target as HTMLInputElement)?.files?.[0] || null;
  form.cover_image = file;
  if (!file) {
    return;
  }

  const reader = new FileReader();
  reader.onload = (e: ProgressEvent<FileReader>) => {
    if (e.target && typeof e.target.result === 'string') {
      imagePreviewUrl.value = e.target.result;
    }
  };

  reader.readAsDataURL(file);
};

const clearImage = () => {
  form.cover_image = null;
  imagePreviewUrl.value = null;
  (document.getElementById('cover_image') as HTMLInputElement)!.value = '';
};
</script>

<template>
  <div class="py-12">
    <DefaultSection class="max-w-3xl">

      <h1> {{ isUpdate ? "Edit Album" : "Add Album" }} </h1>

      <form @submit.prevent="submit" class="mt-8">
        <div class="grid grid-cols-3 gap-5">
          <div class="grid gap-2 col-span-2">
            <Label for="title">Title</Label>
            <Input
              id="title"
              type="text"
              v-model="form.title"
              autofocus
              required
            />
            <InputError :message="form.errors.title"/>
          </div>

          <div class="grid gap-2">
            <Label for="release_date">Release Date</Label>
            <Input
              id="release_date"
              type="date"
              v-model="form.release_date"
              required
            />
            <InputError :message="form.errors.release_date"/>
          </div>

          <div class="grid gap-2 col-span-2">
            <Label for="artist">Artist</Label>
            <v-select id="artist" @search="fetchArtists" v-model="form.artist" :options="artistOptions" :clearable="false"/>
            <InputError :message="form.errors.artist_id"/>
          </div>

          <div class="grid gap-2">
            <Label for="type">Type</Label>
            <v-select id="type" v-model="form.type" :options="types" :clearable="false"/>
            <InputError :message="form.errors.type"/>
          </div>

          <div class="grid gap-2 col-span-3">
            <Label for="cover_image">Cover Image</Label>
            <div class="flex items-center gap-2">

              <Input
                id="cover_image"
                type="file"
                accept="image/*"
                @change="handleImageUpload"
              />
              <Button
                type="button"
                variant="destructive"
                @click="clearImage"
                v-if="imagePreviewUrl"
              >
                <X class="h-5 w-5"/>
              </Button>
            </div>


            <div v-if="imagePreviewUrl">
              <p class="text-sm text-zinc-500 mb-2">Selected Image Preview:</p>
              <div class="w-full h-full">
                <img :src="imagePreviewUrl" alt="Selected Image Preview"
                     class="border-2 border-zinc-700 rounded-md object-center object-cover aspect-square w-full"/>
              </div>
            </div>

            <p v-if="isUpdate" class="text-sm text-yellow-600">
              Uploading a new image will replace the current album cover.
            </p>

            <InputError :message="form.errors.cover_image"/>
          </div>
        </div>

        <Button type="submit" class="mt-4" :tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
          {{ isUpdate ? "Update" : "Create" }}
        </Button>
      </form>

    </DefaultSection>
  </div>
</template>
