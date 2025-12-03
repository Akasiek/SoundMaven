<script setup lang="ts">
import { Label } from "@/components/shadcn/ui/label";
import { Input } from "@/components/shadcn/ui/input";
import InputError from "@/components/inputs/InputError.vue";
import { InertiaForm } from "@inertiajs/vue3";

defineProps<{
  form: InertiaForm<{
    password: string;
    password_confirmation: string;
  }>;
}>();
</script>

<template>
  <div class="grid grid-cols-2 gap-x-6 gap-y-4 items-center justify-center border-t border-zinc-700">
    <h3 class="col-span-2 mb-4"> Password </h3>
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
</template>
