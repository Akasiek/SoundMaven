<script setup lang="ts">

useHead({
  title: '404 - Page not found',
});

const subTitles = [
  'Are you lost little one?',
  'You seem to be in the wrong place',
  'You are not supposed to be here',
  'You are not alone, but you are lost',
  'You are not lost, you are just misplaced',
  'You are not lost, you are just off the beaten path',
  'You are not lost, you are just exploring',
];

const kaomojis = [
  '(ﾉಥ益ಥ)ﾉ',
  'ಠ_ಠ',
  '(｡╯︵╰｡)',
  '(╥﹏╥)',
  '(⊙﹏⊙)',
    '(╯°□°）╯︵ ┻━┻',
    '┻━┻ ︵ヽ(`Д´)ﾉ︵ ┻━┻',
]

const randomSubTitle = subTitles[Math.floor(Math.random() * subTitles.length)];
const randomKaomoji = kaomojis[Math.floor(Math.random() * kaomojis.length)];
</script>

<template>
  <section class="flex flex-col items-center justify-center min-h-screen relative">
    <div class="relative text-center">
      <p class=" text-zinc-400">
        {{ randomSubTitle }}
      </p>
      <h1 class="text-9xl font-black">404</h1>
      <NuxtLink to="/" class="underline text-lg mt-2 hover:text-accent-primary transition-colors">Go back home
      </NuxtLink>
      <p id="kaomoji" class="text-lg text-zinc-600 absolute -bottom-16 inset-x-0">
        {{ randomKaomoji }}
      </p>
    </div>
  </section>
</template>

<style scoped>

</style>