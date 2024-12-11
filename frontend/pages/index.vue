<script lang="ts" setup>
import { useAuthStore } from "~/store/auth";

const store = useAuthStore();
const { isAuth } = storeToRefs(store)

const handleLogout = async () => {
  await store.logout();
};

</script>

<template>
  <main class="py-8">

    <h1 class="text-3xl">Hello world!</h1>

    <p>
      User is {{ isAuth ? 'logged in' : 'not logged in' }}
    </p>

    <NuxtLink v-if="!isAuth" to="/login" class="bg-green-300 py-2 px-4 rounded m-4 inline-block">
      Login
    </NuxtLink>
    <button v-else class="bg-red-300 py-2 px-4 rounded m-4 inline-block" @click="handleLogout">
      Logout
    </button>

    <NuxtLink to="/about">
      About
    </NuxtLink>


  </main>

</template>
