<script setup lang="ts">
import DefaultSection from "@/components/DefaultSection.vue";
import { useForm } from "@inertiajs/vue3";
import { Input } from "@/components/shadcn/ui/input";
import { Label } from "@/components/shadcn/ui/label";
import { onMounted, ref } from "vue";
import { Button } from "@/components/shadcn/ui/button";
import { LoaderCircle } from "lucide-vue-next";

defineProps<{
  types: string[],
}>();

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
  title: '',
  release_date: new Date().toISOString().slice(0, 10), // Default to today
  type: 'LP',
  artist: null,
  artist_id: undefined,
  cover_image: null,
});

const submit = () => {
  console.log('Submitting form:', form.data());
  if (form.artist) {
    form.artist_id = form.artist.id;
  }

  form.post(route('albums.store'), {
    onSuccess: () => form.reset(),
    onError: (errors) => {
      console.error('Form submission errors:', errors);
      // Handle errors as needed, e.g., show a notification or display error messages
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
</script>

<template>
  <div class="py-12">
    <DefaultSection class="max-w-3xl">

      <h1> Add Album </h1>

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
          </div>

          <div class="grid gap-2">
            <Label for="release_date">Release Date</Label>
            <Input
              id="release_date"
              type="date"
              v-model="form.release_date"
              required
            />
          </div>

          <div class="grid gap-2 col-span-2">
            <Label for="artist">Artist</Label>
            <v-select id="artist" @search="fetchArtists" v-model="form.artist" :options="artistOptions" :clearable="false"/>
          </div>

          <div class="grid gap-2">
            <Label for="type">Type</Label>
            <v-select id="type" v-model="form.type" :options="types" :clearable="false"/>
          </div>

          <div class="grid gap-2 col-span-3">
            <Label for="cover_image">Cover Image</Label>
            <Input
              id="cover_image"
              type="file"
              accept="image/*"
              @change="handleImageUpload"
            />

            <div v-if="imagePreviewUrl">
              <p class="text-sm text-zinc-500 mb-2">Selected Image Preview:</p>
              <img :src="imagePreviewUrl" alt="Selected Image Preview" class="border-2 border-zinc-700 rounded-md w-full"/>
            </div>
          </div>
        </div>

        <Button type="submit" class="mt-8" :tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
          Create
        </Button>
      </form>

    </DefaultSection>
  </div>
</template>
