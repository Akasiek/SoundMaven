<script setup lang="ts">
import { Check, Pencil, Plus, Trash, X } from "lucide-vue-next";
import { useAuthUser } from "@/composables/useAuthUser";
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger, } from "@/components/shadcn/ui/dialog"
import { Button } from "@/components/shadcn/ui/button";
import { useForm } from "@inertiajs/vue3";
import { Input } from "@/components/shadcn/ui/input";
import InputError from "@/components/inputs/InputError.vue";
import { Label } from "@/components/shadcn/ui/label";
import { Separator } from "@/components/shadcn/ui/separator";

const user = useAuthUser();
const { album } = defineProps<{ album: ExtendedAlbum }>();

const form = useForm<{
  tracks: {
    title: string;
    duration: string;
    order: number;
    disc: number;
  }[];
}>({
  tracks: album.tracks ? album.tracks.map((track) => {
    return {
      title: track.title,
      duration: track.length_formatted,
      order: track.order,
      disc: track.disc,
    }
  }) : [
    { title: "", duration: "", order: 1, disc: 1 },
    { title: "", duration: "", order: 2, disc: 1 },
    { title: "", duration: "", order: 3, disc: 1 },
  ],
});

const submit = () => {
  form.put(route('albums.updateTracks', { album: album.slug }), {
    onSuccess: () => {
      form.reset();
    },
    onError: (errors) => {
      console.error("Form submission errors:", errors);
      console.error("Form data:", form.data());
    },
  });
};

const removeTrack = (index: number) => {
  form.tracks.splice(index, 1);
  // Reorder tracks after removal
  form.tracks.forEach((track, i) => {
    track.order = i + 1;
  });
};

const addTrack = () => {
  // Check the disc number of the last track to maintain consistency
  const lastTrack = form.tracks[form.tracks.length - 1];
  const discNumber = lastTrack ? lastTrack.disc : 1;
  form.tracks.push({ title: "", duration: "", order: form.tracks.length + 1, disc: discNumber });
};

const getTrackError = (index: number, field: string): string | undefined => {
  const error = (form.errors as Record<string, string>)?.[`tracks.${index}.${field}`];
  // Remove `tracks.index.field` text from error
  return error ? error.replace(`tracks.${index}.`, '') : undefined;
};

</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <div v-if="user && user.role !== 'user'" title="Add Tracklist"
           class="p-1.5 border border-zinc-700 rounded-md flex items-center gap-2 bg-zinc-850 hover:bg-zinc-700 transition-colors cursor-pointer">
        <Pencil class="w-4 h-4"/>
      </div>
    </DialogTrigger>
    <DialogContent class="grid-rows-[auto_minmax(0,1fr)_auto] max-h-[90dvh]">
      <DialogHeader>
        <DialogTitle>Edit tracklist</DialogTitle>
      </DialogHeader>

      <form class="grid gap-y-4 overflow-y-auto p-1" @submit.prevent="submit">

        <div v-for="(track, index) in form.tracks" :key="index" class="grid grid-cols-[3rem_3rem_1fr_5rem_auto] gap-2 items-center">

          <div class="grid gap-2">
            <Label :for="`track.disc-${index}`" class="font-sans ml-0.5">Disc</Label>
            <Input :id="`track.disc-${index}`" v-model.number="track.disc" type="number" placeholder="1" required/>
          </div>
          <div class="grid gap-2">
            <Label :for="`track.order-${index}`" class="font-sans ml-0.5">Order</Label>
            <Input id="track.order" v-model.number="track.order" type="number" placeholder="1" required/>
          </div>
          <div class="grid gap-2">
            <Label :for="`track.title-${index}`" class="font-sans ml-0.5">Track Title</Label>
            <Input id="track.title" v-model="track.title" type="text" placeholder="Karma Police" required/>
          </div>
          <div class="grid gap-2">
            <Label :for="`track.duration-${index}`" class="font-sans ml-0.5">Duration</Label>
            <Input id="track.duration" v-model="track.duration" type="text" placeholder="3:30" required/>
          </div>
          <Button type="button" variant="destructive" @click="removeTrack(index)" class="mt-auto">
            <Trash :size="32"/>
          </Button>

          <div class="col-span-5">
            <InputError :message="getTrackError(index, 'order')"/>
            <InputError :message="getTrackError(index, 'disc')"/>
            <InputError :message="getTrackError(index, 'title')"/>
            <InputError :message="getTrackError(index, 'duration')"/>
          </div>

        </div>
      </form>

      <template v-if="form.errors.tracks">
        <Separator/>
        <InputError :message="form.errors.tracks"/>
      </template>

      <Separator/>

      <DialogFooter>
        <div class="grid grid-cols-3 gap-2 w-full">
          <Button type="button" variant="destructive" @click="$emit('close')">
            <X/>
            Close
          </Button>
          <Button type="button" variant="secondary" @click="addTrack">
            <Plus :size="12"/>
            Add Track
          </Button>
          <Button type="submit" variant="secondary" @click="submit">
            <Check :size="12"/>
            Save changes
          </Button>
        </div>
      </DialogFooter>
    </DialogContent>
  </Dialog>
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
