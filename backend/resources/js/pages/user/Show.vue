<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from "@/components/shadcn/ui/avatar";
import AlbumCard from "@/components/albums/AlbumCard.vue";

const props = defineProps<{
  user: UserWithStats,
  latestRatings: any
}>();
</script>

<template>
  <main class="container mx-auto grid grid-cols-[1fr_2fr] pt-8 gap-8 mb-18">
    <aside class="bg-zinc-800 rounded-md min-h-24 h-fit">
      <div class="flex items-center gap-4 justify-center p-8 mr-4">
        <Avatar class="w-16 h-16">
          <AvatarImage src="https://github.com/unovue.png" :alt="`${user.name} profile picture`"/>
          <AvatarFallback>CN</AvatarFallback>
        </Avatar>
        <h2>
          {{ user.name }}
        </h2>
      </div>

      <div
        id="user_statistics"
        class="grid grid-cols-3 text-center border-t border-zinc-700 py-6 px-2 text-sm [&>div>p]:text-zinc-400 [&>div>p]:font-sans
        [&>div]:border-l [&>div]:border-zinc-700 [&>div]:px-2 [&>div:first-child]:border-l-0"
      >
        <div>
          <h2> {{ user.stats.average_album_rating }} </h2>
          <p> Average Score </p>
        </div>
        <div>
          <h2> {{ user.stats.album_rating_count }} </h2>
          <p> Ratings </p>
        </div>
        <div>
          <h2> {{ user.stats.album_review_count }} </h2>
          <p> Reviews </p>
        </div>
      </div>

    </aside>
    <section>
      <div>
        <h1> User's Latest Ratings </h1>
        <hr class="w-24 mt-4 mb-6 border-zinc-800">

        <div class="grid grid-cols-4 gap-4">
          <AlbumCard
            v-for="album in latestRatings" :key="album.id"
            :album="album" :show-artist="true" :show-user-rating="true" size="md"
          />
        </div>
      </div>

    </section>
  </main>
</template>
