<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { LogOut, User as UserIcon } from 'lucide-vue-next';
import type { User } from "@/types";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/shadcn/ui/avatar";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from "@/components/shadcn/ui/dropdown-menu";

defineProps<{ user: User; }>();
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
      <DropdownMenuItem :as-child="true">
        <Link prefetch :href="route('users.show', user.slug )">
          <UserIcon class="mr-1 text-zinc-50"/>
          Profile
        </Link>
      </DropdownMenuItem>
      <DropdownMenuSeparator class="bg-zinc-700"/>
      <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="route('logout')" as="button">
          <LogOut class="mr-1 text-zinc-50"/>
          Log out
        </Link>
      </DropdownMenuItem>

    </DropdownMenuContent>
  </DropdownMenu>
</template>

<style scoped>

</style>
