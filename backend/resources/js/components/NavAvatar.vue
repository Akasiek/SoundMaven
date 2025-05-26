<script setup lang="ts">

import { Link } from "@inertiajs/vue3";
import { LogOut } from 'lucide-vue-next';
import type { User } from "@/types";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/shadcn/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/components/shadcn/ui/dropdown-menu";

defineProps<{ user: User; }>();

const handleLogout = () => {
    router.flushAll();
};
</script>

<template>


    <DropdownMenu :modal="false">
        <DropdownMenuTrigger as-child>
            <Avatar class="w-10 h-10">
                <AvatarImage src="https://github.com/unovue.png" alt="@unovue"/>
                <AvatarFallback>CN</AvatarFallback>
            </Avatar>
        </DropdownMenuTrigger>
        <DropdownMenuContent class="min-w-56 rounded-lg" align="end" :side-offset="4">
            <DropdownMenuGroup>
                <!--                <DropdownMenuItem>-->
                <!--                    <User class="mr-2 h-4 w-4"/>-->
                <!--                    <span>Profile</span>-->
                <!--                    <DropdownMenuShortcut>⇧⌘P</DropdownMenuShortcut>-->
                <!--                </DropdownMenuItem>-->
                <!--                <DropdownMenuItem>-->
                <!--                    <CreditCard class="mr-2 h-4 w-4"/>-->
                <!--                    <span>Billing</span>-->
                <!--                    <DropdownMenuShortcut>⌘B</DropdownMenuShortcut>-->
                <!--                </DropdownMenuItem>-->
                <!--                <DropdownMenuItem>-->
                <!--                    <Settings class="mr-2 h-4 w-4"/>-->
                <!--                    <span>Settings</span>-->
                <!--                    <DropdownMenuShortcut>⌘S</DropdownMenuShortcut>-->
                <!--                </DropdownMenuItem>-->
                <!--                <DropdownMenuItem>-->
                <!--                    <Keyboard class="mr-2 h-4 w-4"/>-->
                <!--                    <span>Keyboard shortcuts</span>-->
                <!--                    <DropdownMenuShortcut>⌘K</DropdownMenuShortcut>-->
                <!--                </DropdownMenuItem>-->
            </DropdownMenuGroup>
            <DropdownMenuSeparator/>
            <DropdownMenuItem :as-child="true">
                <Link class="block w-full" method="post" :href="route('logout')" @click="handleLogout" as="button">
                    <LogOut class="mr-2 h-4 w-4"/>
                    Log out
                </Link>
            </DropdownMenuItem>

        </DropdownMenuContent>
    </DropdownMenu>
</template>

<style scoped>

</style>
