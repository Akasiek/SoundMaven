<script setup lang="ts">
import { LoaderCircle } from 'lucide-vue-next';
import { Head, useForm } from '@inertiajs/vue3';
import TextLink from '@/components/TextLink.vue';
import { Button } from "@/components/shadcn/ui/button";
import IslandLayout from "@/layouts/IslandLayout.vue";

defineOptions({layout: null});

defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};
</script>

<template>
    <Head title="Email verification"/>
    <IslandLayout class="max-w-md">
        <div v-if="status === 'verification-link-sent'" class="mb-4 text-center text-sm font-medium text-green-600">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit" class="space-y-6 text-center">
            <Button :disabled="form.processing">
                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin"/>
                Resend verification email
            </Button>

            <TextLink :href="route('logout')" method="post" as="button" class="mx-auto block text-sm"> Log out</TextLink>
        </form>
    </IslandLayout>
</template>
