<main class="max-w-7xl mx-auto">
    <div class="grid grid-cols-4 gap-x-8 gap-y-16 my-32">
        @foreach ($artists as $artist)
            <a href="{{ route('artist.show', $artist->slug) }}"
               class="block border-2 border-zinc-800 overflow-hidden rounded-md hover:border-zinc-600 transition duration-300 ease-in-out hover:scale-102">
                <div class="w-full h-48 aspect-video overflow-hidden relative">
                    <img src="{{$artist->background_image_preview}}" alt="{{ $artist->name }}" class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t to-50% from-zinc-900 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 bg-opacity-50 px-4 py-2">
                        <h2 class="text-zinc-50 text-lg font-bold shadow-zinc-900/50 [text-shadow:_2px_2px_5px_var(--tw-shadow-color)]">{{ $artist->name }}</h2>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    {{--    {{ $artists->links() }}--}}
</main>
