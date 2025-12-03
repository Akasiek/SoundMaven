<script setup lang="ts">
import { LoaderCircle } from "lucide-vue-next";
import { router, useForm } from "@inertiajs/vue3";
import DefaultSection from "@/components/DefaultSection.vue";
import { Button } from "@/components/shadcn/ui/button";
import UpdateProfileInformationSection from "@/components/profile/Edit/UpdateProfileInformationSection.vue";
import UpdateAvatarSection from "@/components/profile/Edit/UpdateAvatarSection.vue";
import UpdateFavArtistSection from "@/components/profile/Edit/UpdateFavArtistSection.vue";

const { user } = defineProps<{ user: User, messages: { success?: string, error?: string } }>();


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
</script>

<template>
  <div class="py-12">
    <DefaultSection class="max-w-4xl mb-12">

      <div class="grid grid-cols-[1fr_2fr] gap-6">
        <div></div>
        <h1> Profile Settings </h1>
      </div>

      <div class="grid grid-cols-[1fr_2fr] gap-6 mt-8">

        <div class="pt-24 -mt-40 sticky top-0 self-start">
          <h3 class="mb-6"> Sections </h3>
          <ul class="space-y-2 font-sans [&>li]:text-sm [&>li]:hover:underline">
            <li><a href="#update-profile-information-section"> Profile Information </a></li>
            <li><a href="#update-avatar-section"> Avatar </a></li>
          </ul>
        </div>

        <form @submit.prevent="submit" class="[&>div]:py-12">

          <UpdateProfileInformationSection :form="form" id="update-profile-information-section"/>
          <UpdateAvatarSection :form="form" :user="user" id="update-avatar-section"/>

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
