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
import { HTMLAttributes, watch } from "vue";
import { cn } from "@/lib/utils";
import { useEventBus } from "@vueuse/core";

const route = useRoute();
const page = usePage<SharedData>();
const bus = useEventBus<string>('reloadSearch');

const user = useAuthUser();
const { album, currentUserReview, isInModal = false, class: className } = defineProps<{
  album: ExtendedAlbum,
  currentUserReview?: AlbumReview | null,
  isInModal?: boolean,
  class?: HTMLAttributes['class']
}>();

const form = useForm({
  body: currentUserReview?.body || '',
  rating: currentUserReview?.rating || '',
  album_id: album.id,
});

const updateFormFromReview = (review: AlbumReview | null | undefined) => {
  const body = review?.body || '';
  const rating = review?.rating || '';

  form.body = body;
  form.rating = rating;
  form.defaults({
    body,
    rating,
    album_id: album.id,
  });
};

watch(
  () => currentUserReview,
  updateFormFromReview,
  { immediate: true }
);

const submit = () => {
  form.post(route('album-reviews.store'), {
    preserveScroll: true,
    onSuccess: () => {
      bus.emit('reloadSearch');
      router.reload();
    }
  });
};

const deleteReview = () => {
  if (currentUserReview) {
    form.delete(route('album-reviews.destroy', currentUserReview.id), {
      preserveScroll: true,
      onSuccess: () => {
        form.defaults({ body: '', rating: '' });
        form.reset('body', 'rating');
        bus.emit('reloadSearch');
        router.reload();
      }
    });
  }
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
  <div v-if="user" id="user-review" :class="cn('bg-zinc-850 border-2 border-zinc-800 shadow-xl rounded-lg p-6', className)">
    <h2 v-if="!isInModal" class="mb-4">Your Review</h2>

    <form @submit.prevent="submit" class="space-y-5">
      <div class="grid grid-cols-[1fr_auto] gap-5">

        <div class="grid gap-2">
          <Label for="body">Review</Label>
          <Textarea
            id="body"
            v-model="form.body"
            class="border-zinc-700 min-h-20 font-sans"
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
            class="border-zinc-700 !text-4xl w-24 h-20 text-center font-bold pb-2 transition-colors text-zinc-900"
            :class="getRatingColor(form.rating.toString())"
          />
        </div>

      </div>

      <InputError :message="form.errors.album_id"/>

      <p v-if="page.props?.success" class="text-green-500"> {{ page.props.success }} </p>

      <div class="space-x-2 flex justify-end">
        <Button
          type="button" variant="destructive" v-if="currentUserReview" @click="deleteReview" :disabled="form.processing" class="cursor-pointer"
        >
          Delete
        </Button>
        <Button type="submit" :disabled="form.processing">
          {{ `${currentUserReview ? "Update" : "Submit"}` }}
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
        </Button>
      </div>

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
