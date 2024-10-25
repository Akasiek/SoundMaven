<script setup lang="ts">
import '@fontsource-variable/montserrat';
import '@fontsource-variable/lora';
</script>

<template>
  <div class="w-full font-sans bg-dark-secondary min-h-screen text-light-primary pl-64">
    <SideNav/>

    <section class="max-w-7xl w-full mx-auto px-4">
      <slot/>
    </section>
  </div>
</template>