<script setup lang="ts">
import { Link, router } from "@inertiajs/vue3";
import { LogOut } from 'lucide-vue-next';
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
      <!-- TODO -->
      <DropdownMenuSeparator class="bg-zinc-700"/>
      <DropdownMenuItem :as-child="true">
        <Link class="block w-full" method="post" :href="route('logout')" @click="handleLogout" as="button">
          <LogOut class="mr-2 h-4 w-4 text-zinc-50"/>
          Log out
        </Link>
      </DropdownMenuItem>

    </DropdownMenuContent>
  </DropdownMenu>
</template>

<style scoped>

</style>
