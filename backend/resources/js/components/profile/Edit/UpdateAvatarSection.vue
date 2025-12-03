<script setup lang="ts">
import { X } from "lucide-vue-next";
import { Label } from "@/components/shadcn/ui/label";
import { Input } from "@/components/shadcn/ui/input";
import InputError from "@/components/inputs/InputError.vue";
import { Button } from "@/components/shadcn/ui/button";
import { InertiaForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const { form, user } = defineProps<{
  form: InertiaForm<{ avatar: File | string | null }>;
  user: User;
}>();

// Use current avatar as initial preview
onMounted(() => {
  if (user.avatar) {
    imagePreviewUrl.value = user.avatar;
  }
});

const imagePreviewUrl = ref<string | null>(null);

const handleImageUpload = (event: Event): void => {
  const file = (event.target as HTMLInputElement)?.files?.[0] || null;
  form.avatar = file;
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
  form.avatar = null;
  imagePreviewUrl.value = user.avatar || null;
  (document.getElementById('avatar') as HTMLInputElement)!.value = '';
};
</script>

<template>
  <div class="space-y-6 border-t  border-zinc-700">
    <h3> Update Avatar </h3>

    <div class="flex items-center gap-4 col-span-3">
      <div class="max-w-32">
        <div class="w-full h-full">
          <img v-if="imagePreviewUrl" :src="imagePreviewUrl" alt="Selected Image Preview"
               class="border-2 border-zinc-700 rounded-full object-center object-cover aspect-square w-32"/>
          <div v-else class="border-2 border-zinc-700 rounded-full bg-zinc-800 w-32 aspect-square flex items-center justify-center">
            <span class="text-zinc-500 text-center"> No Avatar Provided </span>
          </div>
        </div>
      </div>
      <div class="min-w-64 space-y-2 mb-2">
        <Label for="cover_image">Avatar</Label>
        <div class="flex items-center gap-2">

          <Input
            id="avatar"
            type="file"
            accept="image/*"
            @change="handleImageUpload"
            :tabindex="5"
          />
          <Button
            type="button"
            variant="destructive"
            @click="clearImage"
            v-if="imagePreviewUrl"
            :tabindex="6"
          >
            <X class="h-5 w-5"/>
          </Button>
        </div>
        <InputError :message="form.errors.avatar" class="mt-4"/>
      </div>
    </div>
  </div>
</template>
