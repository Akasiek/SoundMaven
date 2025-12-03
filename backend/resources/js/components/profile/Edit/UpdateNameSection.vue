<script setup lang="ts">
import { Label } from "@/components/shadcn/ui/label";
import { Input } from "@/components/shadcn/ui/input";
import InputError from "@/components/inputs/InputError.vue";
import { InertiaForm } from "@inertiajs/vue3";

defineProps<{
  form: InertiaForm<{
    name: string;
    email: string;
  }>;
}>();
</script>

<template>
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
</template>
