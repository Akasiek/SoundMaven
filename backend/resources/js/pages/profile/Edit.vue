<script setup lang="ts">
import { onMounted, ref } from "vue";
import { LoaderCircle, X } from "lucide-vue-next";
import { router, useForm } from "@inertiajs/vue3";
import DefaultSection from "@/components/DefaultSection.vue";
import { Input } from "@/components/shadcn/ui/input";
import { Label } from "@/components/shadcn/ui/label";
import InputError from "@/components/inputs/InputError.vue";
import { Button } from "@/components/shadcn/ui/button";

const { user } = defineProps<{ user: User, messages: { success?: string, error?: string } }>();

const imagePreviewUrl = ref<string | null>(null);

const form = useForm<{
  email: string,
  name: string,
  password: string,
  password_confirmation: string,
  avatar: File | string | null,
}>({
  email: user.email || '',
  name: user.name || '',
  password: '',
  password_confirmation: '',
  avatar: null,
});

// Use current avatar as initial preview
onMounted(() => {
  if (user.avatar) {
    imagePreviewUrl.value = user.avatar;
  }
})

const submit = () => {
  router.post(route('profile.update'), {
    ...form.data(),
    _method: 'put',
  }, {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('password', 'password_confirmation');
    },
    onError: (errors) => {
      form.setError(errors);
      console.error('Form submission errors:', errors);
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
  imagePreviewUrl.value = user.avatar || null;
  (document.getElementById('avatar') as HTMLInputElement)!.value = '';
};
</script>

<template>
  <div class="py-12">
    <DefaultSection class="max-w-4xl mb-12">

      <h1> Profile Settings </h1>

      <div class="grid grid-cols-[1fr_2fr] gap-6 mt-8">

        <div class="pt-24 -mt-16 sticky top-0 self-start">
          <h3 class="mb-6"> Sections </h3>
          <ul class="space-y-2 font-sans">
            <li><a href="#update-profile-section" class="text-sm hover:underline"> Profile Information </a></li>
            <li><a href="#update-password-section" class="text-sm hover:underline"> Password </a></li>
            <li><a href="#avatar-section" class="text-sm hover:underline"> Avatar </a></li>
          </ul>
        </div>

        <form @submit.prevent="submit" class="[&>div]:py-8">

          <div class=" grid grid-cols-2 gap-x-6 gap-y-4 items-center justify-center border-t border-zinc-700" id="update-profile-section">
            <h3 class="col-span-2 mb-4"> Update Profile Information </h3>
            <div class="grid gap-2">
              <Label for="name">Name</Label>
              <Input
                id="name"
                type="text"
                v-model="form.name"
                placeholder="Name"
                :tabindex="1"
              />
            </div>

            <div class="grid gap-2">
              <Label for="email">Email</Label>
              <Input
                id="email"
                type="email"
                v-model="form.email"
                placeholder="Email"
                :tabindex="2"
              />
            </div>

            <InputError :message="form.errors.name"/>
            <InputError :message="form.errors.email"/>

          </div>

          <div class=" grid grid-cols-2 gap-x-6 gap-y-4 items-center justify-center border-t border-zinc-700" id="update-password-section">
            <h3 class="col-span-2 mb-4"> Update Password </h3>
            <div class="grid gap-2">
              <Label for="password">New Password</Label>
              <Input
                id="password"
                type="password"
                v-model="form.password"
                placeholder="Password"
                :tabindex="3"
              />
            </div>

            <div class="grid gap-2">
              <Label for="password_confirmation">Confirm New Password</Label>
              <Input
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                placeholder="Confirm Password"
                :tabindex="4"
              />
            </div>
            <InputError :message="form.errors.password" class="col-span-2"/>
          </div>

          <div class="space-y-6 border-t  border-zinc-700" id="avatar-section">
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

          <div class="flex items-center gap-x-5 mt-6 py-0!">

            <p class="grow text-sm text-green-500" v-if="messages.success">
              {{ messages.success }}
            </p>
            <p class="grow text-sm text-red-500" v-if="messages.error || form.hasErrors">
              {{ messages.error || 'Please fix the errors above and try again.' }}
            </p>

            <Button type="submit" class="block ml-auto cursor-pointer" :tabindex="7" :disabled="form.processing">
              <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
              Update
            </Button>
          </div>
        </form>

      </div>

    </DefaultSection>
  </div>
</template>
