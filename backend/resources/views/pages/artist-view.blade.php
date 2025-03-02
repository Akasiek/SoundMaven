<main class="max-w-7xl mx-auto">
    <section class="w-full relative">
        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent"></div>
        <div class="aspect-video w-full">
            <img src="{{ $artist->background_image }}" alt="{{ $artist->name }} background" class="w-full h-full object-center object-cover">
        </div>

        <div class="absolute inset-x-0 bottom-10 mx-10">

            <h1 class="text-6xl font-black text-white">
                {{ $artist->name }}
            </h1>
        </div>
    </section>

    <section>
        @livewire(\App\Livewire\AlbumList::class, ['albums' => $artist->albums, 'showArtist' => false])
    </section>
</main>
