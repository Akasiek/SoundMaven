<script setup lang="ts">
import { ref } from "vue";
import { LoaderCircle, X } from "lucide-vue-next";
import { router, useForm } from "@inertiajs/vue3";
import DefaultSection from "@/components/DefaultSection.vue";
import { Input } from "@/components/shadcn/ui/input";
import { Label } from "@/components/shadcn/ui/label";
import InputError from "@/components/inputs/InputError.vue";
import { Button } from "@/components/shadcn/ui/button";

defineProps<{ user: User, messages: { success?: string, error?: string } }>();

const imagePreviewUrl = ref<string | null>(null);

const form = useForm<{
  password: string,
  password_confirmation: string,
  avatar: File | null,
}>({
  password: '',
  password_confirmation: '',
  avatar: null,
});

const submit = () => {
  router.post(route('profile.update'), {
    ...form.data(),
    _method: 'put',
  }, {
    onSuccess: () => {
      form.reset();
      clearImage();
    },
    onError: (errors) => {
      console.error('Form submission errors:', errors, form);
    },
  });
};

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
  imagePreviewUrl.value = null;
  (document.getElementById('avatar') as HTMLInputElement)!.value = '';
};
</script>

<template>
  <div class="py-12">
    <DefaultSection class="max-w-4xl">

      <h1> Profile Settings </h1>

      <div class="grid grid-cols-[1fr_2fr] gap-6 mt-8">

        <div class="pt-24 -mt-16 sticky top-0 self-start">
          <h3 class="mb-6"> Sections </h3>
          <ul class="space-y-2">
            <li><a href="#update-password-section" class="text-sm hover:underline"> Update Password </a></li>
            <li><a href="#avatar-section" class="text-sm hover:underline"> Update Avatar </a></li>
          </ul>
        </div>

        <form @submit.prevent="submit">

          <div class="space-y-6 border-t py-8 border-zinc-700" id="update-password-section">
            <h3> Update Password </h3>
            <div class="grid gap-2">
              <Label for="password">New Password</Label>
              <Input
                id="password"
                type="password"
                :tabindex="3"
                v-model="form.password"
                placeholder="Password"
              />
              <InputError :message="form.errors.password"/>
              <p v-if="form.errors.password" class="text-sm text-red-600 mt-1">{{ form.errors.password }}</p>
            </div>

            <div class="grid gap-2">
              <Label for="password_confirmation">Confirm New Password</Label>
              <Input
                id="password_confirmation"
                type="password"
                :tabindex="4"
                v-model="form.password_confirmation"
                placeholder="Confirm Password"
              />
              <InputError :message="form.errors.password_confirmation"/>
            </div>
          </div>

          <div class="space-y-6 border-t py-6 border-zinc-700" id="avatar-section">
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
              </div>
            </div>
          </div>

          <p class="mt-6 text-sm text-green-500" v-if="messages.success">
            {{ messages.success }}
          </p>
          <p class="mt-6 text-sm text-red-500" v-if="messages.error">
            {{ messages.error }}
          </p>

          <Button type="submit" class="mt-6" :tabindex="4" :disabled="form.processing">
            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
            Update
          </Button>
        </form>

      </div>

    </DefaultSection>
  </div>
</template>
