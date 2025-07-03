<script setup lang="ts">
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import { Button } from "@/components/shadcn/ui/button";
import { Textarea } from "@/components/shadcn/ui/textarea";
import { Input } from "@/components/shadcn/ui/input";
import { Label } from "@/components/shadcn/ui/label";
import InputError from "@/components/inputs/InputError.vue";
import { LoaderCircle } from "lucide-vue-next";
import { useRoute } from "ziggy-js";
import { useAuthUser } from "@/composables/useAuthUser";
import { getRatingColor as getRatingColorName } from "@/composables/getRatingColor";
import { SharedData } from "@/types";

const route = useRoute();
const page = usePage<SharedData>();

const user = useAuthUser();
const { album, currentUserReview } = defineProps<{ album: ExtendedAlbum, currentUserReview: AlbumReview | null }>();

const form = useForm({
  body: currentUserReview?.body || '',
  rating: currentUserReview?.rating || '',
  album_id: album.id,
});

const submit = () => {
  form.post(route('album-reviews.store'), {
    preserveScroll: true,
    onSuccess: () => {
      router.reload({ only: ['album'] });
    }
  });
};

const getRatingColor = (rating: string | number) => {
    const colors = {
      red: '!bg-red-400 text-zinc-900',
      yellow: '!bg-yellow-400 text-zinc-900',
      green: '!bg-green-400 text-zinc-900',
      zinc: '!bg-transparent text-zinc-50',
      default: '!bg-transparent text-zinc-50',
    };
    return colors[getRatingColorName(rating)] || colors.default;
  };
</script>

<template>
  <div id="user-review" class="bg-zinc-850 border-2 border-zinc-800 shadow-xl rounded-lg p-6" v-if="user">
    <h2 class="mb-4">Your Review</h2>

    <form @submit.prevent="submit" class="space-y-5">
      <div class="grid grid-cols-[1fr_auto] gap-5">

        <div class="grid gap-2">
          <Label for="body">Review</Label>
          <Textarea
            id="body"
            v-model="form.body"
            class="border-zinc-700 min-h-20"
            placeholder="Share your thoughts about the album..."
          ></Textarea>
          <InputError :message="form.errors.body"/>
        </div>

        <div class="grid grid-rows-[auto_1fr] gap-2">
          <Label for="rating">Rating</Label>
          <Input
            id="rating"
            type="number"
            v-model="form.rating"
            placeholder="Ø"
            min="0"
            max="100"
            required
            class="border-zinc-700 !text-4xl h-full w-24 text-center font-bold pb-2 transition-colors text-zinc-900"
            :class="getRatingColor(form.rating.toString())"
          />
        </div>

      </div>

      <InputError :message="form.errors.album_id"/>

      <p v-if="page.props?.success" class="text-green-500">
        {{ page.props.success }}

      </p>

      <Button type="submit" :disabled="form.processing">
        {{ `${currentUserReview ? "Update" : "Submit"} Review` }}
        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
      </Button>

    </form>
  </div>
  <div v-else class="bg-zinc-850 border-2 border-zinc-800 shadow-xl rounded-lg p-6">
    <Link :href="route('login')" class="underline">Log in</Link>
    to write a review.
  </div>
</template>

<style scoped>
@layer base {
  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
}
</style>
