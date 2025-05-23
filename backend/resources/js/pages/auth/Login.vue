<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import IslandLayout from "@/layouts/IslandLayout.vue";
import { Input } from "@/components/shadcn/ui/input";
import InputError from "@/components/inputs/InputError.vue";
import TextLink from "@/components/TextLink.vue";
import { Checkbox } from "@/components/shadcn/ui/checkbox";
import { Button } from "@/components/shadcn/ui/button";

import Symbol from "@/assets/symbol.svg"

defineOptions({layout: IslandLayout});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Login" />

    <div class="flex justify-between items-center mb-8">

        <h1 class="text-3xl font-bold">
            Login
        </h1>

        <img :src="Symbol" alt="Green bolt" class="h-10 w-10 mt-1"/>
    </div>

    <form @submit.prevent="submit" class="space-y-5">
        <div class="grid gap-5">
            <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input
                    id="email"
                    type="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    v-model="form.email"
                    placeholder="email@example.com"
                />
                <InputError :message="form.errors.email"/>
            </div>

            <div class="grid gap-2">
                <div class="flex items-center justify-between">
                    <Label for="password">Password</Label>
                    <!-- TODO -->
                    <!-- <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm" :tabindex="5">-->
                    <!--     Forgot password?-->
                    <!-- </TextLink>-->
                </div>
                <Input
                    id="password"
                    type="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    v-model="form.password"
                    placeholder="Password"
                />
                <InputError :message="form.errors.password"/>
            </div>

            <div class="flex items-center justify-between">
                <Label for="remember" class="flex items-center space-x-3">
                    <Checkbox id="remember" v-model="form.remember" :tabindex="3"/>
                    <span class="mb-0.5">Remember me</span>
                </Label>
            </div>

            <Button type="submit" class="w-full" :tabindex="4" :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
                Log in
            </Button>
        </div>

        <div class="text-center text-sm text-zinc-400">
            Don't have an account?
            <TextLink :href="route('register')" :tabindex="5">Sign up</TextLink>
        </div>
    </form>
</template>

<style scoped>

</style>
