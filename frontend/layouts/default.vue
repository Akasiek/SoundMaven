<script setup lang="ts">
import '@fontsource-variable/montserrat';
import '@fontsource-variable/lora';
</script>

<template>
  <div class="w-full font-sans bg-dark-secondary min-h-screen text-light-primary">
    <SideNav/>

    <main class="max-w-5xl w-full mx-auto pl-64">
      <slot/>
    </main>
  </div>
</template>